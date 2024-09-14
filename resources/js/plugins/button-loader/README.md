# button-loader
A jquery plugin which add loading indicators into buttons

## Instructions
You will need to include both the jquery.buttonloader.js and buttonLoader.css along with bootstrap.css and font-awesome.css

### HTML
The buttons or links that should have the loading indication must be given the class "has-spinner".
Below is an example of a button and a link which have loading indication.

```sh
<button class="btn btn-primary my-btn has-spinner">Button01</button>
<a class="btn btn-primary my-btn has-spinner">Button02</a>
```
### Jquery
To start loading
```sh
$('.my-btn').buttonLoader('start');
```
To stop loading
```sh
$('.my-btn').buttonLoader('stop');
```
#### Example
http://jsfiddle.net/zcX4h/1154/
