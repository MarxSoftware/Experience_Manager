/**
 * WordPress Dependencies
 */
import { __ } from "@wordpress/i18n";
import {
  InspectorControls,
} from "@wordpress/editor";
import {
  PanelBody,
  SelectControl,
  ToggleControl,
  TextControl,
  Autocomplete
} from "@wordpress/components";
import { Fragment } from "@wordpress/element";

//import Select from 'react-select';

/**
 *
 * @param {object} props component props
 * @returns {object} Component
 */
const Inspector = props => {
  // Attributes
  const { attributes, setAttributes } = props;
  const {
    tma_personalization,
    tma_matching,
    tma_group,
    tma_default,
    tma_segments
  } = attributes;

  const onEnableTargeting = newEnabled => {
    setAttributes({ tma_personalization: newEnabled });
  };
  const onMatchingModeChanged = newMode => {
    setAttributes({ tma_matching: newMode });
  };
  const onGroupNameChanged = newGroupName => {
    setAttributes({ tma_group: newGroupName });
  };
  const onGroupDefaultChanged = newGroupDefault => {
    setAttributes({ tma_default: newGroupDefault });
  };
  const onSegmentsChanged = newSegments => {
    setAttributes({ tma_segments: newSegments });
  }

  const targetingControls = (
    <Fragment>
      <SelectControl
        label={__('Matching mode:')}
        value={tma_matching} // e.g: value = [ 'a', 'c' ]
        onChange={onMatchingModeChanged}
        options={[
          { value: 'all', label: 'All' },
          { value: 'any', label: 'Any' },
          { value: 'none', label: 'None' },
        ]}
      />
      <TextControl
        label={__("Group name?")}
        value={tma_group}
        onChange={onGroupNameChanged}
      />
      <ToggleControl
        label={__("Group default?")}
        checked={!!tma_default}
        onChange={onGroupDefaultChanged}
      />
      <SelectControl
        multiple
        label={__('Audiences')}
        value={tma_segments} // e.g: value = [ 'a', 'c' ]
        onChange={onSegmentsChanged}
        options={TMA_CONFIG.segments.map(preset => {
          return {
            value: preset.id,
            label: preset.name
          };
        })}
      />
      

    </Fragment>
  );


  // Inspector Controls
  return (
    <InspectorControls>
      <PanelBody title={__("Targeting")} initialOpen={true}>

        <ToggleControl
          label={__("Enable")}
          checked={!!tma_personalization}
          onChange={onEnableTargeting}
        />
        {tma_personalization && targetingControls}
      </PanelBody>
    </InspectorControls>
  );
};

export default Inspector;
