const RECOMMEND_FREQUENCY = Object.freeze({
  NONE: 0,
  MIDDLE: 1,
  HIGH: 2
})

const CURRENT_LOCATION_SUGGEST = Object.freeze({
  BROWSER: 0,
  PERMISSION: 1,
  UNAVAILABLE: 2,
  TIMEOUT: 3,
  SUGGEST: 4
})

const DIRECTION_TYPE = Object.freeze({
  NONE: {
    NUM: 0,
    TEXT: '指定なし'
  },
  NORTH: {
    NUM: 1,
    TEXT: '北（North）'
  },
  EAST: {
    NUM: 2,
    TEXT: '東（East）'
  },
  SOUTH: {
    NUM: 3,
    TEXT: '南（South）'
  },
  WEST: {
    NUM: 4,
    TEXT: '西（West）'
  }
})

export default {
  RECOMMEND_FREQUENCY,
  CURRENT_LOCATION_SUGGEST,
}

export {
  DIRECTION_TYPE
}