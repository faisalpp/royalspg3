<?php 
namespace VanguardLTE
{
    class SportLive extends \Illuminate\Database\Eloquent\Model
    {
        protected $table = 'sports_lives';
        protected $fillable = [
            'ip', 
            'status'
        ];
        public $timestamps = false;
        public static function boot()
        {
            parent::boot();
        }
    }

}
