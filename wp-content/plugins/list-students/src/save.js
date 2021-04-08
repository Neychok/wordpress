import { __ } from "@wordpress/i18n";
import { useBlockProps } from "@wordpress/block-editor";
import { map } from "lodash";
import "./style.scss";

export default function save({ attributes }) {
	console.log;
	const { students } = attributes;

	return (
		<div className="students">
			{map(students, (student) => {
				if (student.student_status !== attributes.whichToShow) {
					return;
				}

				let studentImage;
				if (
					student._embedded !== undefined &&
					student._embedded["wp:featuredmedia"]["0"].source_url !== undefined
				) {
					studentImage = student._embedded["wp:featuredmedia"]["0"].source_url;
				} else {
					studentImage = "https://placeimg.com/150/150/people";
				}

				return (
					<a className="student" href="#">
						<img className="student-image" src={studentImage} />
						<h3 className="student-name">{student.title.rendered}</h3>
					</a>
				);
			})}
		</div>
	);
}
