import { registerBlockType } from "@wordpress/blocks";
import Edit from "./edit";
registerBlockType("create-block/list-students", {
	apiVersion: 2,
	title: "List students",
	icon: "megaphone",
	category: "widgets",
	attributes: {
		students: {
			type: "array",
		},
		studentToShow: {
			type: "number",
			default: 5,
		},
		whichToShow: {
			type: "string",
			default: "active",
		},
	},
	edit: Edit,
	save: () => null,
});
