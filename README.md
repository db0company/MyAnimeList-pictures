# ![MyAnimeList](http://cdn.myanimelist.net/images/mal-logo-small.jpg) Pictures

A solution to display pictures on [MyAnimeList](myanimelist.net).

## How can I add pictures on my anime list?

* Go to `Profile` then `Edit` then `My List Style` then `Advanced Style CSS Editor`
(or use [this link](http://myanimelist.net/editprofile.php?go=stylepref&do=cssadv)).
* At the beginning of your CSS file, add this line and replace `USERNAME` by your username.

```css
@import url("http://malcss.db0.fr/USERNAME");
```

* If you want to use small pictures, add `?size=small` at the end of the URL:

```css
@import url("http://malcss.db0.fr/USERNAME?size=small");
```

Default size: ![big picture example](http://cdn.myanimelist.net/images/anime/8/28483.jpg)
Small size: ![small picture example](http://cdn.myanimelist.net/images/anime/8/28483t.jpg)

## Parties

###### [MyAnimeList](myanimelist.net)

MyAnimeList is one of the biggest Japanese animes and mangas references
on the Internet for reviews, suggestions and catalog about animes.

Users can create profile, an anime list and a manga list.
For instance, this is my anime list: http://myanimelist.net/animelist/db0

###### [MyAnimeList Unofficial API](http://mal-api.com/)

This unofficial API is the easiest way to get information from MyAnimeList
in a convenient format.

## How did you do that?

Here is a quick, dirty, easy to understand piece of code that explains the solution:
```php
<?php
header("Content-Type: text/css");
$list = json_decode(file_get_contents('http://mal-api.com/animelist/db0'));
foreach ($list->anime as $anime) { ?>
a[href^="http://myanimelist.net/anime/<?= $anime->id ?>/"]:before {
content: url(<?= $anime->image_url ?>);
}
<?php } ?>
```
The full code is available here: https://github.com/db0company/MyAnimeList-pictures/blob/master/index.php

# Copyright/License

    Copyright 2013 Barbara Lepage
   
    Licensed under the Apache License, Version 2.0 (the "License");
    you may not use this file except in compliance with the License.
    You may obtain a copy of the License at
   
        http://www.apache.org/licenses/LICENSE-2.0
   
    Unless required by applicable law or agreed to in writing, software
    distributed under the License is distributed on an "AS IS" BASIS,
    WITHOUT WARRANTIES OR CONDITIONS OF ANY KIND, either express or implied.
    See the License for the specific language governing permissions and
    limitations under the License.    
   
### Author

* Made by  	db0
* Contact		db0company@gmail.com
* Website		http://db0.fr/


### Up to date

 /!\ Latest version is on GitHub :
* https://github.com/db0company/MyAnimeList-pictures
