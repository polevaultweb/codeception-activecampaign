Codeception ActiveCampaign
==========

An ActiveCampaign email marketing module for Codeception.

## Installation
You need to add the repository into your composer.json file

```bash
composer require --dev polevaultweb/codeception-activecampaign
```

## Usage

You can use this module as any other Codeception module, by adding 'ActiveCampaign' to the enabled modules in your Codeception suite configurations.

### Add ActiveCampaign to your list of modules

```yml
modules:
    enabled:
        - ActiveCampaign
 ```  

### Setup the configuration variables

```yml
    config:
        ActiveCampaign:
            api_key: '%ACTIVECAMPAIGN_API_KEY%'
            api_url: '%ACTIVECAMPAIGN_API_URL%'
 ```     
 
Update Codeception build
  
```bash
codecept build
 ```
  
### Supports

* getActiveCampaignsForSubscriber
* deleteSubscriber

And assertions

* seeCustomFieldForSubscriber
* seeTagsForSubscriber
* cantSeeTagsForSubscriber
* seeCampaignsForSubscriber
* cantSeeCampaignsForSubscriber
* waitForSubscriberToNotHaveTags

### Usage

```php
$I = new AcceptanceTester( $scenario );

$I->seeTagsForSubscriber( 'john@gmail.com', array( 'customer', 'product-x' ) );
$I->seeCampaignsForSubscriber( 'john@gmail.com', array( 12345, 67890 ) );

```

