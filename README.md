# MonkCMS-Meta | <a href="https://styleci.io/repos/80335341"><img src="https://styleci.io/repos/80335341/shield?branch=master" alt="StyleCI"></a>
A collection of classes to generate module meta information for the MonkCMS API

### How to use
Within a template you would initialize the class for the module you are working with.  In this example we will assume the pages module.
```php
//Load these in a config.php file
require_once($_SERVER['DOCUMENT_ROOT'] . '/monkcms.php');
require_once($_SERVER['DOCUMENT_ROOT'] . '/vendor/autoload.php');
$currentUrl = 'http://' . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'];

//This would go in the page template after config.php is included
$meta = new \Meta\Module\PageMeta(
    $_GET['nav'],
    getSiteName(),
    'http://' . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI']
);
```

Then, in `head.php` (or anywhere you wish) you can do the following
```html
<title><?= $meta->title() ?></title>
<?= $meta->createMetaTag('description', $meta->description()) ?>
<?= $meta->createMetaTag('keywords', $meta->keywords()) ?>
<?= $meta->socialTags() ?>
```

The following would be generated
```html
<title>Example Page Title | Test Site Name</title>
<meta name="description" content="Example Page Description" >
<meta name="keywords" content="Example, Page, Keywords" >
<meta property="og:site_name" content="Test Site Name" >
<meta property="og:type" content="article" >
<meta property="og:title" content="Example Page Title | Test Site Name" >
<meta property="og:url" content="http://example.com" >
<meta property="og:image" content="http://www.placecage.com/1200/630" >
<meta property="og:image:width" content="1200" >
<meta property="og:image:height" content="630" >
<meta name="twitter:card" content="summary_large_image" >
```

### Included modules
- Pages
- Sermons
- Articles
- Blogs
- Events

---
Further documentation can be found at http://liftoff.ekklesia360.com or by looking at the tests.
