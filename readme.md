#TwigContentBundle

This twig tag extension helps to provide content snippets from different sources. It also provides a fallback case if no content retriever is defined.

## Usage

```twig
{% content status_no_projects_yet %}
    This is the default text for the content snippet with the identifier status_no_projects_yet. 
    It will appear if the configured retriever does not return content.
{% endcontent %}
```

## Content Retriever

### Null Retriever
The null retriever returns the text defined inside the content block. The null retriever is the standard retriever and must not be configured.

### Http Retriever
The http retriever can be used to fetch content via an http request.

```yml
# app/config/service.yml

services:
    phmlabs.content.retriever:
        class: phmLabs\TwigContentBundle\Retriever\HttpRetriever
        arguments: ["http://cms.koalamon.com/#identifier#"]
```
