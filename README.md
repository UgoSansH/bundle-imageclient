# bundle-imageclient

Client from service image api


Beta Version
================

**Dont' use in production.**



Installation
==============

Add Bundle to your composer.json

```json
    "ugosansh/bundle-clientimage": "~0.1"
```

Enable bundle

```php
<?php
class AppKernel extends Kernel
{
    public function registerBundles()
    {
        $bundles = [
            ...
                new Ugosansh\Bundle\Image\ClientBundle\UgosanshImageClientBundle(),
            ...
        ];

?>
```



Configuration reference
========================

```yml

ugosansh_image_client:
    api: # Node api based from m6web WsClientBundle
        base_url: "http://api.domain.tld"
        config:
            timeout: 2
            exceptions: false
    logger: logger_service_name # (Option) A logger from WsClient service
    default_image: "img/default-image.jpg" # (Option) Define default image
    entity_class: Acme\Bundle\MyBundle\Entity\Image # (Option)

```

This bundles require [https://github.com/M6Web/WsClientBundle](m6web/wsclient-bundle)

The configuration node **api** extends the configuration reference of WsClientBundle.



Use from twig template
=======================

```html

<!-- render(ImageInterface image, int width = null, int height = null, int crop = null, array attr = []); -->
{{ image_render(image, 200, 100, 1, {'class': 'thumbnail'}) }}

```

