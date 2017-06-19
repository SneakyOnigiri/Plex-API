# Plex-API
PHP class for Plex API

## Table
Function | Parameters | Description
-------- | ---------- |-----------
__construct | | Create object
GetInfo | | Get info about transcode bitrate and Plex authentication
NowPlaying | | Get all currently playing media
GetHistory | | Get latest played media
Search | string $query | Search for a media in the library
GetSections | | Get all sections from the remote host
BrowseSection | int $id / string $key| Browse a section and filter it's media
DeleteSection | int $id | Remove a section from the remote host library
GetPreferences | | Get the server preferences
GetServers | | Get the local list of servers
GetOnDeck | | Get the list of paused shows
GetPhoto | string $url / int $width / int $height | Get a library image (Artwork, thumb, ...)
MyAccount | | Get Plex account information (Based on token)

## Documentation
### Create Plex object
To start using this class, you have to initialize it. Format can either be json or array
```php
$Plex = new Plex('IP', 'PORT', 'TOKEN', 'FORMAT');
```
### Browse a section
With GetSections function, we can retrieve sections ID and therefore browse it's content.
```php
echo $Plex->BrowseSections(2, 'onDeck');
```
This portion of code will output
```json
{  
   "MediaContainer":{  
      "size":15,
      "allowSync":true,
      "art":"/:/resources/show-fanart.jpg",
      "identifier":"com.plexapp.plugins.library",
      "librarySectionID":2,
      "librarySectionTitle":"Animes",
      "librarySectionUUID":"2f9f2a17-9ae5-4aec-b2a1-cf08e5a1c150",
      "mediaTagPrefix":"/system/bundle/media/flags/",
      "mediaTagVersion":1491999474,
      "mixedParents":true,
      "nocache":true,
      "thumb":"/:/resources/show.png",
      "title1":"Animes",
      "title2":"On Deck",
      "viewGroup":"episode",
      "viewMode":65592,
      "Metadata":[  ]
   }
}
```
Where "Metadata" array contains information about section's media
