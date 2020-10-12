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
- Go to Settings > Brian Album Review Settings and enter your Last.FM API Key. Click the "Save Changes" button after entering your API key. 

---

## 👓  `Usage of this plugin`
- Clikc on Album Review in the WordPress admin
- Click Add New to add your first album review
- Start entering the title of the album you would like to review. 
- You will get a populated list from Last.FM for the album you are typing in
- Select the album you would like to review
- Enter the Genre as well as the rating you would like to give this album. You can add multiple genres here. Also, genre's you have added in the past will show up as checkboxes. 
- Click Publish
- You will now have a shortcode above the Publish Metabox that you can copy and past anywhere you would like. 
- This shortcode can also be found in Album Review > All Album Reviews
- You also have two other shortcodes. One to show recent album reveiws and another to show album reviews by genere.
- To show the most recent albums you have reviewed use the shortcode <code>[recent-albums]</code>. The default amount is 5 albums. You can override this by adding the following into your shortcode. <code>[recent-albums albums="3"]</code>. Change the 3 to however many albums you would like to show. 
- To show albums from a certain genere, you can use the shortcode like the following <code>[albums-genre genre="punk"]</code>. The default number of albums to get from a genere is 5. You can change this by adding the same <code>albums="3"</code> like the recent-albums shortcode. i.e <code>[albums-genre genre="edm" albums="2"]</code>. 