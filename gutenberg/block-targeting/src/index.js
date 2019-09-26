/**
 * External Dependencies
 */
import { assign } from "lodash";
import classnames from "classnames";

/**
 * WordPress Dependencies
 */
import { addFilter } from "@wordpress/hooks";
import { Fragment } from "@wordpress/element";
import { createHigherOrderComponent } from "@wordpress/compose";

/**
 * Internal Dependencies
 */
import targetingSettings from "./data/attributes";
import Inspector from "./components/inspector";
import "./style.scss";

/**
 * Filters registered block settings, extending attributes with targeting settings
 *
 * @param {Object} settings Original block settings.
 * @return {Object} Filtered block settings.
 */
function addAttributes(settings) {
  //console.log("addAttributes");
  // Use Lodash's assign to gracefully handle if attributes are undefined
  settings.attributes = assign(settings.attributes, targetingSettings);
  //settings.attributes = assign(settings.attributes, { "data-attribute": ['tma_personalization', 'tma_matching', 'tma_group', 'tma_default', 'tma_segments'] });
  //console.log(settings);
  return settings;
}

/**
 * Override the default edit UI to include a new block inspector control for
 * background settings.
 *
 * @param {function|Component} BlockEdit Original component.
 * @return {string} Wrapped component.
 */
const withInspectorControl = createHigherOrderComponent(BlockEdit => {
  //console.log("withInspectorControl");
  return props => {
    return (
      <Fragment>
        {props.isSelected && <Inspector {...{ ...props }} />}
        <BlockEdit {...props} />
      </Fragment>
    );
  };
}, "withInspectorControl");

/**
 * Override the default block element to add background wrapper props.
 *
 * @param  {Function} BlockListBlock Original component
 * @return {Function}                Wrapped component
 */
const withBackground = createHigherOrderComponent(BlockListBlock => {
  //console.log('withBackground');
  return props => {
    let wrapperProps = props.wrapperProps;
    wrapperProps = {
      ...wrapperProps
    };

    return <BlockListBlock {...props} wrapperProps={wrapperProps} />;
  };
}, "withBackground");

/**
 * Override props assigned to save component to inject background atttributes
 *
 * @param {Object} extraProps Additional props applied to save element.
 * @param {Object} blockType  Block type.
 * @param {Object} attributes Current block attributes.
 *
 * @return {Object} Filtered props applied to save element.
 */
function addBackground(extraProps, blockType, attributes) {
  //console.log("addBackground");
  //extraProps.style = getStyle(attributes);
  const { tma_personalization, tma_matching, tma_group, tma_default, tma_segments } = attributes;
  var settings = {};
  if (tma_personalization) {
    settings['data-tma-personalization'] = tma_personalization ? "enabled" : "disabled";
    settings['data-tma-matching'] = tma_matching;
    settings['data-tma-group'] = tma_group;
    settings['data-tma-default'] = tma_default ? "yes" : "no";
    if (Array.isArray(tma_segments)) {
      settings['data-tma-segments'] = tma_segments.join(",");
    } else {
      settings['data-tma-segments'] = [];
    }
    if (!tma_default) {
      settings['class'] = "tma-hide";
    }

    assign(extraProps, settings);
  }


  return extraProps;
}

function addAssignedBackgroundSettings(elem, blockType, attr) {
  //console.log("addAssignedBackgroundSettings");
  //console.log(elem);
  //console.log(attr);
  //extraProps.style = getStyle(attributes);
  /*
  const { tma_personalization, tma_matching, tma_group, tma_default, tma_segments } = attributes;
  var settings = {};
  settings['data-tma-personalization'] = tma_personalization ? "enabled" : "disabled";
  settings['data-tma-matching'] = tma_matching;
  settings['data-tma-group'] = tma_group;
  settings['data-tma-default'] = tma_default ? "yes" : "no";
  if (Array.isArray(tma_segments)) {
    settings['data-tma-segments'] = tma_segments.join(",");
  } else {
    settings['data-tma-segments'] = [];
  }
  if (!tma_default) {
    settings['class'] = "tma-hide";
  }

  assign(extraProps, settings);
*/
  return elem;
}

addFilter(
  "blocks.registerBlockType",
  "tma/targeting/attribute",
  addAttributes
);

addFilter(
  "editor.BlockEdit",
  "tma/targeting/inspector",
  withInspectorControl
);
/*
addFilter(
  "editor.BlockListBlock",
  "tma/targeting/withBackground",
  withBackground
);
*/
addFilter(
  "blocks.getSaveContent.extraProps",
  "lubus/background/addAssignedBackground",
  addBackground
);

/*
addFilter(
  "blocks.getSaveElement",
  "tma/targeting/addAssignedBackgroundSettings",
  addAssignedBackgroundSettings
);
*/