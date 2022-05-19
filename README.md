# VForms

## A custom WordPress plugin to create forms and collect data.

### Create a VForm custom post type item

Login as an editor or an administrator.

From the admin area, click the "Forms" tab. Use the drag and drop interface to create a form. 

&nbsp;&nbsp; **REQUIRED:** Add a text input field called "vform-rec-id". If you don't, the form won't save.

"Publish" the Vform. The VForm can only be seen in the frontend via the generated shortcode.

&nbsp;&nbsp; **OPTIONAL** Consider publishing the post / page as "private".

Go to the "Forms" tab again. Notice that each VForm has a "shortcode" listed. Copy and paste the shortcode into any post / page. Publish the post / page as "Private". This will permit only admins or editors to see the page containing the VForm.

When a VForm is submitted a new "VData" custom post type item is created in the "Data" tab.

### Edit a VData custom post type item

Login as an editor or an administrator.

From the admin area, click the "Data" tab. 

Click the link for a VForm-Record-ID to get to the frontend form that created the VData item. 

&nbsp;&nbsp; *Optional:* You can click "edit" in the inline option under the link, to go to a more detailed editor. i.e. to see "revisions".

&nbsp;&nbsp; *Optional:* If you know the "vdata" vform-rec-id, you can add the following query item to a page with a VForm shortcode, via the browser URL:

**ht<span>tp://</span>yoursite.com/page-with-vform-shortcode-in-content/?vform-rec-id={vform_rec_id}**

This will auto-populate the vform. 

### Roles and Capabilities
A user who can "edit_others_posts" can use this plugin. It is assumed all users "editor" and above can modify the data in a VData custom post type item. Actions are recorded in the "revisions".
