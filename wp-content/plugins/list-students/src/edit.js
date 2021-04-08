import { useBlockProps, InspectorControls } from "@wordpress/block-editor";
import {
	Panel,
	PanelBody,
	PanelRow,
	RadioControl,
	__experimentalNumberControl as NumberControl,
} from "@wordpress/components";
import { Fragment } from "@wordpress/element";
import "./editor.scss";
import ServerSideRender from "@wordpress/server-side-render";

/**
 * Main function that renders the admin side
 */
const Edit = (props) => {
	const { attributes, setAttributes } = props;

	// RADIO options
	const radioOptions = [
		{ label: "Active", value: "active" },
		{ label: "Inactive", value: "inactive" },
	];
	// Fires when user clicks on a option
	const whichToShowOnChange = (changedOption) => {
		setAttributes({ whichToShow: changedOption });
	};

	// NUMBER CONTROL
	// Fire when user changes how much students to show
	const studentToShowOnChange = (changedNumber) => {
		setAttributes({ studentToShow: parseInt(changedNumber, 10) });
	};

	return (
		<div {...useBlockProps()}>
			{/* Wrapper for the sidebar */}
			<Fragment>
				<InspectorControls key="setting">
					<Panel id="gutenpride-controls">
						<PanelBody title="Settings" initialOpen={true}>
							<PanelRow>
								<RadioControl
									id="default-radiogroup"
									label="Which students to show"
									onChange={whichToShowOnChange}
									selected={attributes?.whichToShow}
									options={radioOptions}
								/>
							</PanelRow>
							<PanelRow>
								<NumberControl
									label="Number of students"
									className="student-number"
									onChange={studentToShowOnChange}
									value={attributes.studentToShow}
									min="1"
									max="25"
								/>
							</PanelRow>
						</PanelBody>
					</Panel>
				</InspectorControls>
			</Fragment>

			{/* Component that renders the block */}
			<ServerSideRender block={props.name} attributes={attributes} />
		</div>
	);
};
export default Edit;
