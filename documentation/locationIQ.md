

# Reverse Geocoding API

Reverse geocoding is the process of converting a coordinate or location (latitude, longitude) to a readable address or place name. This permits the identification of nearby street addresses, places, and/or area subdivisions such as a neighborhood, county, state, or country.

# Try the Reverse Geocoding demo

<HTMLBlock>
  {`
  <iframe src=\"https://docs-snippets.locationiq.com/demo/reverse/\" allow=\"geolocation\" width=\"100%\" height=\"550\" frameborder=\"0\"></iframe>
  `}
</HTMLBlock>

***

# Call the Reverse Geocoding API in your application

This guide will help you convert geographic coordinates to addresses in no time!

> 🔑 Do You Have Your Access Token?
>
> Before you proceed, ensure you have your access token at hand. **Can't find your token?** No worries — our guide will assist you in either [creating a new one or finding your existing token](/docs/locationiq-access-token).

## 1. Making Your First API Call

We have a set of coordinates at hand: `latitude 48.8584 and longitude 2.2945`. Let's find out what notable place these coordinates point to!

Use the following URL to make the API call to the Reverse Geocoding API:

```http
https://us1.locationiq.com/v1/reverse?key=YOUR_ACCESS_TOKEN&lat=48.8584&lon=2.2945&format=json
```

```curl curl
curl "https://us1.locationiq.com/v1/reverse?key=YOUR_ACCESS_TOKEN&lat=48.8584&lon=2.2945&format=json"
```

For a hands-on experience,  [click here](https://us1.locationiq.com/v1/reverse?key=YOUR_ACCESS_TOKEN\&lat=48.8584\&lon=2.2945\&format=json) to make the API call right from your browser. Just replace `YOUR_ACCESS_TOKEN` with your token.

### Sample Response

If all goes well, you'll receive a response in JSON format, which will look something like:

```json
{
    "place_id": "123456",
    "licence": "https://locationiq.com/attribution",
    "lat": "48.8584",
    "lon": "2.2945",
    "display_name": "Eiffel Tower, Avenue Anatole France, Quartier du Gros-Caillou, Paris, Île-de-France, Metropolitan France, 75007, France",
    ...
}
```

The coordinates point to the iconic Eiffel Tower in Paris, France. The `display_name` value gives us the full address of this landmark.

## 3. Implement in Your Application

You can now use these coordinates to place a marker on a map in your application or for any other purpose that requires the geographic coordinates of an address.

## 4. Read the API Reference for more

You can tweak API responses to return less or more details, in a different format or apply additional cleaning by using additional parameters. Check the full [API reference](/reference/reverse-api) for more details.

# Tips & Best Practices

* **Endpoint Selection**: Always choose the endpoint (**`us1`** or **`eu1`**) closer to the majority of your user base for faster response times.
* **URL Encoding**: Ensure that the address string is URL encoded, especially if it contains special characters or spaces.
* **Rate Limits**: Be aware of the API rate limits. If you're making frequent requests, consider caching results to reduce redundant calls and retry failed requests after a short while.
* **Multiple Results:** The API can return multiple results for ambiguous queries. Ensure your application can handle and appropriately display multiple geocoding results.

***

# Brief Overview of Request / Response Parameters

The information presented below is a condensed summary. For a more detailed and exhaustive list of parameters, refer to [API Reference Page](docs/reverse-geocoding).

## Request

Requests can be sent to any of the following endpoints

Region 1: US

```html
https://us1.locationiq.com/v1/reverse?key=YOUR_ACCESS_TOKEN&lat=LATITUDE&lon=LONGITUDE&format=json
```

Region 2: Europe

```html
https://eu1.locationiq.com/v1/reverse?key=YOUR_ACCESS_TOKEN&lat=LATITUDE&lon=LONGITUDE&format=json
```

***

### Request Example

```shell
curl --request GET \
     --url 'https://us1.locationiq.com/v1/reverse?lat=51.5233879&lon=-0.1582367&format=json&key=kiara' \
     --header 'accept: application/json'
```

```javascript
var settings = {
  "async": true,
  "crossDomain": true,
  "url": "https://us1.locationiq.com/v1/reverse?key=YOUR_ACCESS_TOKEN&lat=-37.870662&lon=144.9803321&format=json",
  "method": "GET"
}

$.ajax(settings).done(function (response) {
  console.log(response);
});
```

```python
import requests

url = "https://us1.locationiq.com/v1/reverse"

data = {
    'key': 'YOUR_ACCESS_TOKEN',
    'lat': '-37.870662',
    'lon': '144.9803321',
    'format': 'json'
}

response = requests.get(url, params=data)

print(response.text)
```

```php
<?php

$curl = curl_init('https://us1.locationiq.com/v1/reverse?key=YOUR_ACCESS_TOKEN&lat=-37.870662&lon=144.9803321&format=json');

curl_setopt_array($curl, array(
  CURLOPT_RETURNTRANSFER    =>  true,
  CURLOPT_FOLLOWLOCATION    =>  true,
  CURLOPT_MAXREDIRS         =>  10,
  CURLOPT_TIMEOUT           =>  30,
  CURLOPT_CUSTOMREQUEST     =>  'GET',
));

$response = curl_exec($curl);
$err = curl_error($curl);

curl_close($curl);

if ($err) {
  echo "cURL Error #:" . $err;
} else {
  echo $response;
}
```

### Required Parameters

| Name | Description                                           |
| :--- | :---------------------------------------------------- |
| key  | Authentication key.                                   |
| lat  | Latitude of the location to generate an address for.  |
| lon  | Longitude of the location to generate an address for. |

### Frequently used parameters (optional):

| Name             | Description                                                                                                                                                                                                                                                                                                                                                                                                                      |             Values             |
| ---------------- | -------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------- | :----------------------------: |
| format           | Output Format. Defaults to `xml` for compatibility. Switching to`json` / `xml1.1` is recommended.                                                                                                                                                                                                                                                                                                                                | \[`json` \|`xml` \| `xmlv1.1`] |
| addressdetails   | Include a breakdown of the address of this result into elements. Defaults to `1`. [Read more.](/docs/address-details)                                                                                                                                                                                                                                                                                                            |          \[`0` \| `1`]         |
| accept-language  | Preferred language order for showing search results, overrides the value specified in the `Accept-Language` HTTP header. Defaults to `en`. To use native language for the response when available, use `accept-language=native`. Either uses standard [rfc2616 accept-language string](https://tools.ietf.org/html/rfc2616#section-14.4) or a simple comma-separated list of language codes. [Read more.](/docs/accept-language) |                                |
| normalizeaddress | Makes parsing of the `address` object easier by returning a predictable and [defined list of elements](/docs/normalize-address). Defaults to `0` for backward compatibility. We recommend setting this to `1` for new projects.                                                                                                                                                                                                  |          \[`0` \|`1`]          |
| statecode        | Adds state or province code when available to the `state_code` key inside the `address` object. Currently supported for addresses in the USA, Canada, and Australia. Defaults to `0`                                                                                                                                                                                                                                             |          \[`0` \| `1`]         |

> 📘 **Note**
>
> List of all input parameters available on the [API Reference page](/reference/reverse-api)

***

## Response

> 📘 **Compatibility**
>
> This version (v1) of our Reverse Geocoding API is compatible with OpenStreetMap's Nominatim Geocoder in both JSON & XML formats. However, all our enhancements such as additional datasets and algorithms are supported only in `json` or `xmlv1.1` format options.

### Response Example

```json
{
  "place_id": "60310287",
  "licence": "https://locationiq.com/attribution",
  "osm_type": "node",
  "osm_id": "5568763423",
  "lat": "51.5233879",
  "lon": "-0.1582367",
  "display_name": "221B Baker Street, Baker Street, Marylebone, London, Greater London, England, NW1 6XE, United Kingdom",
  "address": {
    "attraction": "221B Baker Street",
    "road": "Baker Street",
    "suburb": "Marylebone",
    "city": "London",
    "state_district": "Greater London",
    "state": "England",
    "postcode": "NW1 6XE",
    "country": "United Kingdom",
    "country_code": "gb"
  },
  "boundingbox": [
    "51.5233379",
    "51.5234379",
    "-0.1582867",
    "-0.1581867"
  ]
}
```

### Response Parameters

| Name          | Description                                                                                                                                                                                                                                   |
| ------------- | --------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------- |
| lat           | The Latitude of this result                                                                                                                                                                                                                   |
| lon           | The Longitude of this result                                                                                                                                                                                                                  |
| display\_name | The display name of this result, with complete address                                                                                                                                                                                        |
| address       | The address breakdown into individual components. Returned when `addressdetails=1` is set in the request. Important components include (but not limited to) country, postcode, state, county, city, town. [Read more](/docs/address-details). |
| statecode     | A state or province code when available. Returned when `statecode` is set in the request                                                                                                                                                      |

> 📘 **Note**
>
> List of all response parameters available on the [API Reference page](/reference/reverse-api)

***

# Other Ways to Access Reverse Geocoding

* [Interactive Playground (demo)](/docs/reverse-geocoding-sandbox)
* [Google Sheet](/docs/quickstart-google-sheets-and-locationiq) (no-code option)
