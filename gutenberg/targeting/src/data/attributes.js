/**
 * Attributes Object
 */
const targetingSettings = {
  tma_personalization: {
    type: "boolean",
    default: false
  },
  tma_matching: {
    type: "string",
    default: "all"
  },
  tma_group: {
    type: "string",
    default: "default"
  },
  tma_default: {
    type: "boolean",
    default: false
  },
  tma_segments: {
    type: "array",
    default: []
  }
};

export default targetingSettings;
