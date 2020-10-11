This project is WordPress plugin that registers a CPT called Album Reviews. It allows you to select and album from Last.FM and save all of that metadata so you don't have to manually enter it. You are able to create a shortcode and render the post type on the front end of any post or page.

Below you will find some information on how to setup and use this plugin in a local enviroment. 

## 👉  `Install The Plugin`
- <code>git clone</code> this repository into your <code>/wp-content/plugins</code>. 
- Or, you can download this project from GitHub as a Zip file and install it like a normal plugin.

---

## 🎶  `Get a Last.FM API Key`
- Go to <a href="https://www.last.fm/api/account/create">https://www.last.fm/api/account/create</a>. 
- Either sign-in or sign-up for Last.FM
- Fill out the Contact email and Appliication name field the rest are not needed.
- Click the Submit Button. You will then have your API Key. Save this somewhere important as you won't be able to retrieve it again. (Hint: Save the page CTRL + S and store it somewhere good.).

---

## 🚀  `Activate and Setup`
- Go to Plugins > Installed Plugins > Album Review - A Gutenberg Block > Activate
- Go to Settings > Album Review Settings and enter your Last.FM API Key. Click the "Save Changes" button after entering your API key. 

---

## 👓  `Usage of this plugin`
- Clikc on Album Review in the WordPress admin
- Click Add New to add your first album review
- Start entering the title of the album you would like to review. 
- You will get a populated list from Last.FM for the album you are typing in
- Select the album you would like to review
- Enter the Genre as well as the rating you would like to give this album. 