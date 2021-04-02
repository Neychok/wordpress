
# Neycho @ DevriX | Onboarding Tasks

## Day 1:

Completed:

- Tasks from day 1 to 4

	- Installed Wordpress.

	- Installed Contact Form 7, Duplicate Post, DX Localhost.

	- Created child theme of TwentyTwentyOne Theme.

	- Added dixy image on all posts.

		- Struggle #1: style.css of child theme worked at first but then I changed something and now it doesn't work.

Uncompleted:

- Tasks from day 5

	- Make a plugin that uses filters to edit the html output of posts the_content()

	- Struggle #1: Couldn't think of a way to insert a div inside a paragraph.

## Day 2:

Completed:

- Uncompleted tasks from day 5

	- Managed to complete the task I couldn't from yesterday

- Tasks from day 6

	- Create a custom menu with a option (checkbox) that enables/disable filters from the previous task

	- Struggle #1: Had some problems with ajax, jquery and request handling but resolved them with some assistance from the vim-user sitting next to me.ⱼₖ

- Started day 7 tasks

Uncompleted:

- Tasks from day 7

	- Creating a new plugin with an admin menu where you can provide an Amazon link and display the results in the admin menu page.

## Day 3:

Completed:

- Tasks from day 7

	- Struggle #1: Understanding the end goal of the task and how the page should be displayed

	- Struggle #2: Displaying the results in a non-broken way.

- Tasks from day 8

	- Use the transients API to cache the amazon results from the last task's plugin

	- Transients seemed pretty straight forward.

- Tasks from day 9

	- Build a custom post type ‘student’

		- Creating the custom post type was easy.

	- Struggle #1: Pagination is not working on student archive page

Uncompleted:

	- Pagination of student archive page

	- Display the picture, name and the excerpt of the student.

## Day 4:

Completed:

- Pagination of student archive page

	- Had to comment out code from previous tasks because it was overwriting posts_per_page.

- Rest of tasks from yesterday

- Tasks from day 10

	- Create custom meta boxes and display them on the front end.

	- Created a custom column with checkbox that saves its state with ajax.

- Tasks from day 11

	- Created a custom shortcode that takes Student ID as attr and displays that student.

	- Created a widget with posts per page field and a dropdown whether to look for active or inactive students on the admin side. It uses WP_Query to display students that match the args.

## Day 5:

Completed:

- Tasks from day 12

	- Created a sidebar and displayed it.

- Tasks from day 13

	- Created 2 public API endpoints that get all students data and student data by ID

- Tasks from day 14

	- Created 3 protected API endpoints for add/edit/delete students.

		- Struggle #1: Not sure how to setup authentication

Uncompleted:

	- Create authentication for API
