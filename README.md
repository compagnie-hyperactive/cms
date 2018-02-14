##EasyAdminBundle Configuration

### Entity Specific controller
```
entities:
    Article:
        class: App\Entity\Article
        controller: App\Controller\Admin\ArticleController
```

### Change the template for a specific field
```
Image:
    class: App\Entity\Media\Image
    list:
        fields:
            - { property: 'image', template: 'EasyAdmin/Image/list/image.html.twig' }
```

### Change the form type for a specific field
```
Event:
    class: App\Entity\Event
    form:
        fields:
            - { property: headBandImage, type: 'App\Form\Type\AddOrChooseImageType', label: 'Image' }
```