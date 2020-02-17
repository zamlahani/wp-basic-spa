# WordPress Basic Single Page Application
A basic single page application Wordpress theme

## How To Install
### Manually (You must have a Wordpress site installed first!)
1. Download the ZIP file
1. Extract it to `/wp-content/themes/` folder (you can rename it if you want)
1. Go to Wordpress Admin Dashboard then go to `Appearance->Themes`
1. Select and activate Schantique
1. Create a new page, set any name you want
1. Set the template to `App`
1. Publish the page
1. Go to `Settings->Reading`
1. Set the `Your homepage displays` to `A static page (select below)`
1. Select the newly created page
1. Save the settings
1. Done! You can visit the homepage to view it
### Via CLI (For development purpose)
1. Clone the repository to `/wp-content/themes/theme-name/`, you can rename `theme-name` as you want
1. Activate the theme (Schantique)
1. Create a new page, set any name you want
1. Set the template to `App`
1. Publish the page
1. Go to `Settings->Reading`
1. Set the `Your homepage displays` to `A static page (select below)`
1. Select the newly created page
1. Save the settings
1. Open terminal in the theme folder
1. Run `npm install`
1. You're good to go, run `gulp` to start developing

## Technologies
- WordPress
- Handlebars
- NPM
- Gulp
- SCSS
- Git (_duh!_)
- etc.
