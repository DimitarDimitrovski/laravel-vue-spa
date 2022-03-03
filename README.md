## SPA Using Vue.js and Laravel as backend for API

This is my example of a SPA implementation.  
After some taught on what to code, I decided to make a recipes app.  
App is split in two parts.
- Front end part, meant for the regular users.
- Back end responsible for the API that is used for displaying data to the front end  
  and an admin dashboard for the admin user.

### Front end uses JWT API authentication and contains several pages and functionalities, such as:

- Home page.
- Recipes page.
- Top cooks page.
- Search bar that leads to search page (Based on recipe name)
- Login/Register/Reset Password page.
- User Account page.
- Cook profile page.
- 404 Page for wrong/invalid links.
- After successful login, user can post comments/replies and reviews  
  for the recipes, create/edit recipes.
- After each successful creation of recipe/review/comment, an email is sent to admin  
  to review the contents.
- After each edit of recipe or review, an email is sent to the admin to review changes.

### Admin login uses the default Laravel (web login). After login, admin is able to access several pages and functionalities, such as:

- Admin dashboard page with chart data about recipes, comments, reviews and cooks
- Access to the Cooks/Recipes/Review/Comments pages.
- View deleted and active records for cooks/recipes/reviews/comments.
- Approve/Reject the created recipe/review/comment.
- After each approval, an email is sent to the author of the recipe/review/comment  
  about the admin's response.
- Admin can also delete cooks/recipes/reviews/comments.

###This app uses:

- Vue.js for the frontend
- Vuex for setting the state after successful JWT Auth
- Vue Router for navigating through the SPA
- Form requests for validating the form data
- DAL
- Events and listeners for sending mails, based on actions.
- Custom email templates
- User/Recipe/Review/Comment factories and seeders (for demo data)
