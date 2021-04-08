import { useBlockProps, InspectorControls } from "@wordpress/block-editor";
import { withSelect } from "@wordpress/data";
import {
	Placeholder,
	Spinner,
	Panel,
	PanelBody,
	PanelRow,
	RadioControl,
	__experimentalNumberControl as NumberControl,
} from "@wordpress/components";
import { Fragment, useEffect } from "@wordpress/element";
import "./editor.scss";
import ServerSideRender from "@wordpress/server-side-render";

const Edit = (props) => {
	const { studentList, attributes, setAttributes } = props;
	const hasStudents = Array.isArray(studentList) && studentList.length;
	if (!hasStudents) {
		return (
			<Placeholder icon="excerpt-view" label={"Post Block"}>
				{!Array.isArray(studentList) ? <Spinner /> : "No students found."}
			</Placeholder>
		);
	}
	let studentArray = [];

	studentList.map((student) => {
		let image;

		if (student._embedded !== undefined) {
			if (student._embedded["wp:featuredmedia"]["0"].source_url !== undefined) {
				image = student._embedded["wp:featuredmedia"]["0"].source_url;
			}
		} else {
			image = "";
		}

		studentArray.push({
			id: student.id,
			name: student.title.rendered,
			image: image,
			link: student.link,
		});
	});

	// RADIO
	const radioOptions = [
		{ label: "Active", value: "active" },
		{ label: "Inactive", value: "" },
	];
	const radioOnChange = (changedOption) => {
		setAttributes({ whichToShow: changedOption });
	};

	// NUMBER CONTROL
	const numberOnChange = (changedNumber) => {
		setAttributes({ students: studentArray });
		setAttributes({ studentToShow: parseInt(changedNumber, 10) });
	};

	useEffect(() => setAttributes({ students: studentArray }), []);

	return (
		<div {...useBlockProps()}>
			<Fragment>
				<InspectorControls key="setting">
					<Panel id="gutenpride-controls">
						<PanelBody title="Settings" initialOpen={true}>
							<PanelRow>
								<RadioControl
									id="default-radiogroup"
									label="Which students to show"
									onChange={radioOnChange}
									selected={attributes.whichToShow}
									options={radioOptions}
								/>
							</PanelRow>
							<PanelRow>
								<NumberControl
									label="Number of students"
									className="student-number"
									onChange={numberOnChange}
									value={attributes.studentToShow}
									min="1"
									max="25"
								/>
							</PanelRow>
						</PanelBody>
					</Panel>
				</InspectorControls>
			</Fragment>
			<ServerSideRender block={props.name} attributes={attributes} />
		</div>
	);
};

export default withSelect((select, ownProps) => {
	const { attributes } = ownProps;

	const postQuery = {
		per_page: attributes.studentToShow,
		_embed: true,
		// metaKey: "student_status",
		// metaValue: "active",
	};
	return {
		studentList: select("core").getEntityRecords(
			"postType",
			"student",
			postQuery
		),
	};
})(Edit);
