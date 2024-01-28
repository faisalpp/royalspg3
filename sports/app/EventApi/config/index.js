export default {
  TOKEN: '131893-un5NSiqwfoPzjW',
  SPORTS: [
    {
      SportId: '1',
      name: 'Soccer'
    },
    {
      SportId: '13',
      name: 'Tennis'
    },
    {
      SportId: '18',
      name: 'Basketball'
    },
    {
      SportId: '12',
      name: 'American football'
    },
    {
      SportId: '3',
      name: 'Cricket'
    },
    {
      SportId: '91',
      name: 'Volleyball'
    },
    {
      SportId: '78',
      name: 'Handball'
    },
    {
      SportId: '16',
      name: 'Baseball'
    },
    {
      SportId: '2',
      name: 'Horse Racing'
    },
    // {
    //   SportId: '4',
    //   name: 'Greyhounds'
    // },
    {
      SportId: '17',
      name: 'Ice Hockey'
    },
    {
      SportId: '14',
      name: 'Snooker'
    },
    {
      SportId: '83',
      name: 'Futsal'
    },
    {
      SportId: '15',
      name: 'Darts'
    },
    {
      SportId: '92',
      name: 'Table Tennis'
    },
    {
      SportId: '94',
      name: 'Badminton'
    },
    {
      SportId: '8',
      name: 'Rugby Union'
    },
    {
      SportId: '19',
      name: 'Rugby League'
    },
    // {
    //   SportId: '36',
    //   name: 'Australian Rules'
    // },
    // {
    //   SportId: '66',
    //   name: 'Bowls'
    // },
    {
      SportId: '9',
      name: 'Boxing/UFC'
    },
    // {
    //   SportId: '75',
    //   name: 'Gaelic Sports'
    // },
    {
      SportId: '90',
      name: 'Floorball'
    },
    {
      SportId: '95',
      name: 'Beach Volleyball'
    },
    {
      SportId: '110',
      name: 'Water Polo'
    },
    // {
    //   SportId: '107',
    //   name: 'Squash'
    // }
  ],
  SPORTS_NAME: {
    '1': 'Soccer',
    '2': 'Horse Racing',
    '3': 'Cricket',
    // '4': 'Greyhounds',
    '8': 'Rugby Union',
    '9': 'Boxing/UFC',
    '12': 'American football',
    '13': 'Tennis',
    '14': 'Snooker',
    '15': 'Darts',
    '16': 'Baseball',
    '17': 'Ice Hockey',
    '18': 'Basketball',
    '19': 'Rugby League',
    // '36': 'Australian Rules',
    // '66': 'Bowls',
    // '75': 'Gaelic Sports',
    '78': 'Handball',
    '83': 'Futsal',
    '90': 'Floorball',
    '91': 'Volleyball',
    '92': 'Table Tennis',
    '94': 'Badminton',
    '95': 'Beach Volleyball',
    // '107': 'Squash',
    '110': 'Water Polo',
  },
  API: {
    LIVE_ENDPOINT: 'https://api.b365api.com/v3/events/inplay',
    PRE_ENDPOINT: 'https://api.b365api.com/v3/events/upcoming',
    ENDED_ENDPOINT: 'https://api.b365api.com/v1/event/view',
    ODDS_ENDPOINT: 'https://api.b365api.com/v2/event/odds',
    LEAGUE_ENDPOINT: 'https://api.b365api.com/v1/league',
    TEAM_ENDPOINT: 'https://api.b365api.com/v1/team',
    LIVE_TIME: '*/30 * * * * *',
    UPCOMIN_TIME: '*/60 * * * * *',
    END_TIME: '*/60 * * * * *',
    PRE_TIME: '*/30 * * * *',
    LEAGUE_TIME: '*/60 * * * *',
    RESULT_TIME: '*/2 * * * *'
    // LIVE_TIME: '*/5 * * * * *',
    // UPCOMIN_TIME: '*/30 * * * * *',
    // PRE_TIME: '*/30 * * * *',
    // LEAGUE_TIME: '*/60 * * * *',
    // RESULT_TIME: '*/2 * * * *'
  }
};