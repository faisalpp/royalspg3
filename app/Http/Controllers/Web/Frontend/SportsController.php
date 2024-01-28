<?php

namespace VanguardLTE\Http\Controllers\Web\Frontend {

    use \VanguardLTE\SportData;
    use \VanguardLTE\SportLive;
    use \VanguardLTE\SportBet;
    use \VanguardLTE\SportLeagues;
    use \VanguardLTE\SportCountries;

    include_once(base_path() . '/app/ShopCore.php');
    include_once(base_path() . '/app/ShopGame.php');
    class SportsController extends \VanguardLTE\Http\Controllers\Controller
    {
        public function test()
        {
            return json_decode('this is test response!');
        }

        public function index()
        {
            $provider = 'all';
            return redirect()->route('frontend.casino', $provider);
        }

        public function pre()
        {
            if (auth()->check()) {
                return array('status' => true, 'user' => auth()->user());
            } else {
                return array('status' => false, 'user' => 'null');
            }
        }

        public function home()
        {

            return view('frontend.app');
        }

        public function getSlip(\Illuminate\Http\Request $request)
        {
            $data = SportData::whereIn('Id', $request->matches)
                    ->whereNotIn('period', ['Finished'])
                    ->get();
            return $data;
        }

        public function get_sports(\Illuminate\Http\Request $request)
        {
            $sports = SportData::select('SportId', 'SportName', \DB::raw('COUNT(SportId) as count'))
                ->where('isPreMatch', $request->isPreMatch)
                ->whereNotIn('period', ['Finished'])
                ->groupBy("SportId")
                ->get();
            return $sports;
        }

        public function get_league(\Illuminate\Http\Request $request)
        {
            $data = SportData::select('LeagueId', 'LeagueName', 'RegionId', 'RegionName', 'cc')
                ->where('SportId', $request->SportId)
                ->where('isPreMatch', $request->isPreMatch)
                ->whereNotIn('period', ['Finished'])
                ->groupBy("LeagueId")
                ->get();
            return $data;
        }

        public function get_sports_data(\Illuminate\Http\Request $request)
        {
            $data = SportData::where('IsPreMatch', $request->isPreMatch)
            ->whereNotIn('period', ['Finished']);

            if($request->SportId) $data = $data->where('SportId', $request->SportId);
            if ($request->RegionId) $data = $data->where('RegionId', $request->RegionId);
            if ($request->LeagueId) $data = $data->where('LeagueId', $request->LeagueId);
            if($request->isPreMatch && !$request->SportId) $data = $data->limit(100);
            if($request->isPreMatch && !$request->RegionId) $data = $data->limit(100);
            if(!$request->isPreMatch) {
                $lives = SportLive::where('SportId', $request->SportId)->pluck('liveIds');
                if(count($lives)) {
                    $lives = explode(",", $lives[0]);
                    $data->whereIn("Id", $lives);
                } else {
                    return [];
                }
            }
            $data = $data->get();
            return $data;
        }

        public function get_init_league(\Illuminate\Http\Request $request)
        {
            $data = [];
            if ($request->sport_id && $request->league_id) {
                $data = SportData::where('time_status', 0)
                    ->where('sport_id', $request->sport_id)
                    ->where('league_id', $request->league_id)
                    ->get();
            } else if ($request->sport_id) {
                $data = SportData::where('time_status', 0)
                    ->where('sport_id', $request->sport_id)
                    ->get();
            } else {
                $topLeague = SportLeagues::select('id')
                    ->where('has_toplist', 1)
                    ->get();
                $league = array();
                foreach ($topLeague as $index => $lea) {
                    array_push($league, $lea->id);
                }
                $data = SportData::whereIn('league_id', $league)
                    ->where('time_status', 0)
                    ->get();
            }
            return json_encode($data);
        }

        public function get_init_live(\Illuminate\Http\Request $request)
        {
            $data = [];
            if ($request->sport_id && $request->league_id) {
                $data = SportData::where('time_status', 1)
                    ->where('sport_id', $request->sport_id)
                    ->where('league_id', $request->league_id)
                    ->get();
            } else if ($request->sport_id) {
                $data = SportData::where('time_status', 1)
                    ->where('sport_id', $request->sport_id)
                    ->get();
            } else {
                $data = SportData::where('time_status', 1)
                    ->get();
            }
            return json_encode($data);
        }

        public function getEvent(\Illuminate\Http\Request $request)
        {
            $data = SportData::where('id', $request->id)->get();
            return $data;
        }

        public function bet(\Illuminate\Http\Request $request)
        {
            $user = \VanguardLTE\User::find(auth()->user()->id);
            $balance = 0;
            $balance_error = 'Not enough your balance';
            if ($request['betType'] == 'single') {
                for ($i = 0; $i < count($request['bet']); $i++) {
                    $balance += $request['bet'][$i]['stake'];
                }
                if ($user->balance < $balance) {
                    return array('status' => false, 'msg' => $balance_error);
                }
                for ($i = 0; $i < count($request['bet']); $i++) {
                    $sportBet = new SportBet;
                    $sportBet->user_id = $request["user_id"];
                    $sportBet->betsId = mt_rand();
                    $sportBet->SportId = $request['bet'][$i]['SportId'];
                    $sportBet->SportName = $request['bet'][$i]['SportName'];
                    $sportBet->home = $request['bet'][$i]['home'];
                    $sportBet->away = $request['bet'][$i]['away'];
                    $sportBet->league = $request['bet'][$i]['league'];
                    $sportBet->eventId = $request['bet'][$i]['eventId'];
                    $sportBet->odds = $request['bet'][$i]['odds'];
                    $sportBet->stake = $request['bet'][$i]['stake'];
                    $sportBet->potential = $request['bet'][$i]['potential'];
                    $sportBet->marketId = $request['bet'][$i]['marketId'];
                    $sportBet->marketType = $request['bet'][$i]['marketType'];
                    $sportBet->title = $request['bet'][$i]['title'];
                    $sportBet->period = $request['bet'][$i]['period'];
                    $sportBet->handicap = $request['bet'][$i]['handicap'];
                    $sportBet->oddType = $request['bet'][$i]['oddType'];
                    $sportBet->betType = $request['betType'];
                    $sportBet->status = 'BET';
                    $sportBet->createdAt = date("Y-m-d h:i:s");
                    $sportBet->updatedAt = date("Y-m-d h:i:s");
                    $sportBet->save();
                }
            } else {
                $balance = $request['multi']['stake'];
                if ($user->balance < $balance) {
                    return array('status' => false, 'msg' => $balance_error);
                }
                $betsId = mt_rand();
                for ($i = 0; $i < count($request['bet']); $i++) {
                    $sportBet = new SportBet;
                    $sportBet->user_id = $request["user_id"];
                    $sportBet->betsId = $betsId;
                    $sportBet->SportId = $request['bet'][$i]['SportId'];
                    $sportBet->SportName = $request['bet'][$i]['SportName'];
                    $sportBet->home = $request['bet'][$i]['home'];
                    $sportBet->away = $request['bet'][$i]['away'];
                    $sportBet->league = $request['bet'][$i]['league'];
                    $sportBet->eventId = $request['bet'][$i]['eventId'];
                    $sportBet->odds = $request['bet'][$i]['odds'];
                    $sportBet->stake = $request['multi']['stake'];
                    $sportBet->potential = $request['multi']['profit'];
                    $sportBet->marketId = $request['bet'][$i]['marketId'];
                    $sportBet->marketType = $request['bet'][$i]['marketType'];
                    $sportBet->title = $request['bet'][$i]['title'];
                    $sportBet->period = $request['bet'][$i]['period'];
                    $sportBet->handicap = $request['bet'][$i]['handicap'];
                    $sportBet->oddType = $request['bet'][$i]['oddType'];
                    $sportBet->betType = $request['betType'];
                    $sportBet->status = 'BET';
                    $sportBet->createdAt = date("Y-m-d h:i:s");
                    $sportBet->updatedAt = date("Y-m-d h:i:s");
                    $sportBet->save();
                }
            }
            $ok = \VanguardLTE\User::where('id', $user->id)->decrement('balance', $balance);
            $user = \VanguardLTE\User::where('id', $user->id)->get();

            foreach ($request['matchs'] as $value) {
                \VanguardLTE\SportData::where('id', $value)->increment('popular', 1);
            }
            return array('status' => $ok, 'data' => $user, 'msg' =>  $ok ? 'Success!' : 'Failed!');
        }

        public function get_history(\Illuminate\Http\Request $request)
        {
            $data = [];
            if (isset(auth()->user()->id)) {
                $data = \VanguardLTE\SportBet::where('user_id', auth()->user()->id)->orderByDesc('created_at')->get();
            }
            return $data;
        }

        public function get_casino_history()
        {
            $data = [];
            if (isset(auth()->user()->id)) {
                $data = \VanguardLTE\StatGame::where('user_id', auth()->user()->id)->orderByDesc('date_time')->get();
            }
            return $data;
        }

        public function get_deposit_history()
        {
            $data = [];
            if (isset(auth()->user()->id)) {
                $data = \VanguardLTE\Payment::where('user_id', auth()->user()->id)->orderByDesc('id')->get();
            }
            return $data;
        }

        public function get_search(\Illuminate\Http\Request $request)
        {
            $data = SportData::where('time_status',  $request->isLive)
                ->whereRaw('LOWER(`home`) LIKE ? ', '%' . $request->key . '%')
                ->orWhereRaw('LOWER(`away`) LIKE ? ', '%' . $request->key . '%')
                ->get();
            return json_encode($data);
        }

        public function getPrePopular(\Illuminate\Http\Request $request)
        {
            $popular = SportData::where('popular',  '>', 0)
                ->where('isPreMatch', true)
                ->get();
            return $popular;
        }

        public function livePopular(\Illuminate\Http\Request $request)
        {

            $popular = SportData::where('popular',  '>', 0)
                ->where('SportId', $request->SportId)
                ->where('IsPreMatch', true)
                ->whereNotIn('period', ['Finished'])
                ->offset(0)->take(7)
                ->get();
            $live = SportData::where('SportId', $request->SportId)
                ->where('IsPreMatch', false)
                ->whereNotIn('period', ['Finished'])
                ->offset(0)->take(7)
                ->get();

            return ['status' => true, 'popular' => $popular, 'live' => $live, 'check' => $request->SportId];
        }

        public function home_casino()
        {
            $shop_id = (\Illuminate\Support\Facades\Auth::check() ? auth()->user()->shop_id : 1);
            $games = \VanguardLTE\Game::where([
                'view' => 1,
                'shop_id' => $shop_id
            ]);

            $detect = new \Detection\MobileDetect();
            $devices = [];
            if ($detect->isMobile() || $detect->isTablet()) {
                $games = $games->whereIn('device', [
                    0,
                    2
                ]);
                $devices = [
                    0,
                    2
                ];
            } else {
                $games = $games->whereIn('device', [
                    1,
                    2
                ]);
                $devices = [
                    1,
                    2
                ];
            }

            $games = $games->offset(0)->take(50)->get();
            return json_decode($games);
        }

        public function get_provider()
        {
            $shop_id = (\Illuminate\Support\Facades\Auth::check() ? auth()->user()->shop_id : 1);
            $games = \VanguardLTE\Game::where([
                'view' => 1,
                'shop_id' => $shop_id
            ]);

            $detect = new \Detection\MobileDetect();
            $devices = [];
            if ($detect->isMobile() || $detect->isTablet()) {
                $games = $games->whereIn('device', [
                    0,
                    2
                ]);
                $devices = [
                    0,
                    2
                ];
            } else {
                $games = $games->whereIn('device', [
                    1,
                    2
                ]);
                $devices = [
                    1,
                    2
                ];
            }

            $games = $games->pluck('original_id');
            
            $cat_ids = \VanguardLTE\GameCategory::whereIn('game_id', $games)->groupBy('category_id')->pluck('category_id');
           
                if (count($cat_ids)) {
                    $categories = \VanguardLTE\Category::whereIn('id', $cat_ids)->orderBy('position', 'ASC')->get();
                    return $categories;
                }
        }

        public function get_casino_game(\Illuminate\Http\Request $request)
        {
            $shop_id = (\Illuminate\Support\Facades\Auth::check() ? auth()->user()->shop_id : 1);
            $games;

            $detect = new \Detection\MobileDetect();
            $devices = [];
            if ($detect->isMobile() || $detect->isTablet()) {
                $games = \VanguardLTE\Game::whereIn('device', [
                    0,
                    2
                ]);
                $devices = [
                    0,
                    2
                ];
            } else {
                $games = \VanguardLTE\Game::whereIn('device', [
                    1,
                    2
                ]);
                $devices = [
                    1,
                    2
                ];
            }

            if ($request->id == 'all') {
                $games = $games->offset($request->page * 12)->take(12)->get();
                return json_decode($games);
            } else {
                $gameId = \VanguardLTE\GameCategory::where('category_id', $request->id)->get();
                
                $categoryId = [];
             
                foreach($gameId as $item) {
                    array_push($categoryId, $item->game_id);
                }

                if (count($categoryId)) {
                    $games = $games->whereIn('id', $categoryId)->offset($request->page * 12)->take(12)->get();
                } else {
                    $games = $games->where('id', 0)->offset($request->page * 12)->take(12)->get();
                }
                return json_decode($games);
            }
        }
    }
}
