# Frontend Edit Button Plugin

The **Frontpage Edit Button** Plugin is for [Grav CMS](http://github.com/getgrav/grav). 

This plugin adds an 'edit this page' button on the frontend pages when logged in with a user account with
admin rights. After clicking the button it will open the Admin Dashboard in another tab in your browser where you can start editing the page.
 
IMPORTANT (1): If no user is logged in as administrator (superuser), the button will **never** show up! 

IMPORTANT (2): You can't login from this plugin itself. You have to login by using the login to enter the Administrator Dashboard. 

It will also work when you have an admin dashboard open in another tab of your browser. The moment you are logged in and are able to edit pages, the button will show up on the frontend pages. The moment you logout you are not able to edit any pages that are at that time displayed. The automatic refresh will prevent this. 

When saving an edited page and by clicking on the preview it will show the page in another tab on your browser. Every time you will edit the page, save it and click back on any preview tab, the content will refresh automatically.

## Requirements

This plugin requires that you have the following plugins installed and enabled:

* admin 
* login

## Installation

Installing the _Frontend Edit Button plugin_ can be done in different ways. The GPM (Grav Package Manager) installation method enables you to quickly and easily install the plugin with a simple terminal command, while the manual method enables you to do so via a zip file.

### GPM Installation (Preferred) **not active yet !!!! **

The simplest way to install this plugin is via the [Grav Package Manager (GPM)](http://learn.getgrav.org/advanced/grav-gpm) through your system's terminal (also called the command line).  From the root of your Grav install type:

    bin/gpm install frontend-edit-button

This will install the Frontpage Edit Button plugin into your `/user/plugins` directory within Grav. Its files can be found under `/your/site/grav/user/plugins/frontend-edit-button`.

### Git clone (Preferred for now) ###

In the user/plugins folder of your site:
```
git clone https://github.com/enovision/grav-frontend-edit-button frontend-edit-button
```
The **frontend-edit-button** at the the end of the the git clone is important !!! 


## Configuration

Before configuring this plugin, you should copy the `user/plugins/frontend-edit-button/frontend-edit-button.yaml` to `user/config/plugins/frontend-edit-button.yaml` and only edit that copy.

Here is the default configuration and an explanation of available options:

```yaml
enabled: true
```

Position of the button
The following options are available:
* (tr) Top right (default)
* (tl) Top left
* (br) Bottom right
* (bl) Bottom left

```yaml
position: tr
```

Show the label on the button
```yaml
showLabel: true
```

Show icon (requires Fontawesome to be loaded)
```yaml
showIcon: true
```

IMPORTANT:
_When both_ `showLabel` _and_ `showIcon` _are disabled, it will use internally_ `showLabel = true` _automatically_.

## Usage

When the plugin is enabled there is nothing else to do, it will show the button on the frontend pages.

It is possible however to switch the frontend editing off per page by adding the following to the header of a page (frontmatter):

```yaml
protectEdit: true
```

### Refreshing
This plugin has a simple mechanism build in that will react on a `blur` and `focus` of the browser tab involved.
The moment you click the button it will open the Dashboard in another tab in the browser. The moment you click back
on the page you have just left by clicking on the button, this page will automatically refresh.

This refresh will always execute when you leave (blur) the tab and click back (focus) on the tab with the presented page.

### CSS and JavaScript

The required CSS and JavaScript will only be loaded if the plugin meets the requirements for executing.

#### CSS

You can change the styling of the button by modifying the `style.scss` file in the `scss` folder. 
It is required that the following CSS tags stay intact:

```css
#frontend-edit-button {
  position: fixed;
  z-index: 10000;
  padding: 5px;
}

#frontend-edit-button.top {
  top: 0;
}

#frontend-edit-button.bottom {
  bottom: 0;
}

#frontend-edit-button.left {
  left: 0;
}

#frontend-edit-button.right {
  right: 0;
}
```

You can compile the SASS by entering in the root of this plugin
`sh scss.sh`. It is required that you have the compiler installed.

## i18n

There is a languages file available for multilanguage support

## Credits

The amazing GRAV CMS Team for building such an amazing CMS.
