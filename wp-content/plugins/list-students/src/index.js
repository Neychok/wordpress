import { registerBlockType } from "@wordpress/blocks";
import Edit from "./edit";
registerBlockType("create-block/list-students", {
	apiVersion: 2,
	title: "List students",
	icon: "megaphone",
	category: "widgets",
	edit: Edit,
	save: () => null, // Should resolve to NULL if you want a dynamic block
});
