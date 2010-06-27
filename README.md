# Pixel
Pixel takes a different approach to blogging. Rather than using a database or an admin or anything that leads to the potential of opening further avenues of attack for a hacker, it uses text files, held in /posts/.

Any text file dropped in /posts/ is parsed and read into the post array, then fed out to the user when they hit the domain, you also get a permalink to the post at a similar location to the physical one.

## Installation
To install, simply drop all of Pixel's files into a directory or root of your choice. Open up pxl/pixel.php and change some configuration settings (namely, give your blog a name, provide a description, your name, whether htaccess is supported on your server etc). That's it!

## Creating Posts
To create a post open up your favourite text editor and create a file with this structure:

`title: My Great Post`  
`author: Thomas Chatting`  
`date: 27/06/2010`  
`Some HTML for the main post!`

Then save this text file in the following way:
`2010-06-27-my-great-post.txt`
Where the date must be YYYY-MM-DD and match the date in the post itself, author is an optional attribute and will default to the one provided in the configuration file. Then leave a clear line and begin coding in HTML or plain text! Then drop this file in /posts/ and voila! You've created your first Pixel post, if you followed the instructions above you could see it at both Pixel's root and `/posts/2010/06/27/my-great-post`

## Future Posts
You can draft out a post you want to hold out on publishing until a later date by simply setting the post date (in the file itself and the filename) to a date later on that the current one.

## RSS
An Atom 2.0 feed is provided and can be accessed at /atom.php.

## Styling
I have provided a quick and dirty index page for you to look at and tinker with, just be aware that if you create your own with your own style that you **must** include the pixel file, you can then include content, page names etc.

## Todo:
* Provide an upload interface for posts
* Allow for Disqus integration out of the box
* Add validation to the text parser