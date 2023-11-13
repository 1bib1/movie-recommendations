This is a simple symfony application created using [symfony/skeleton](https://github.com/symfony/skeleton) and php 8.1.

To start application you can use symfony CLI
```bash
symfony serve -d 
```

Application allows user to get recommendation of 3 movies using selected algorithm. To get recommendations send request to following endpoint:
```
(GET) {baseUrl}/movies/recommendations
```

Three types of recommendations are supported (type query parameter has to be passed):
1. Random,
```
(GET) {baseUrl}/movies/recommendations?type=RANDOM
```
2. Titles with at least 2 words,
```
(GET) {baseUrl}/movies/recommendations?type=MULTIPLE_WORDS_IN_TITLE
```
3. Titles that start with W and consist of even number of characters,
```
(GET) {baseUrl}/movies/recommendations?type=TITLE_STARTS_WITH_W
```

Endpoint supports different number of recommendations (default is 3)
```
(GET) {baseUrl}/movies/recommendations?type=TITLE_STARTS_WITH_W&number=2
```
