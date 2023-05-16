
( function( $ ) {
  function walkThoughNode(element, replacement) {
    for (let node of element.childNodes) {
        switch (node.nodeType) {
            case Node.ELEMENT_NODE:
                walkThoughNode(node, replacement);
                break;
            case Node.TEXT_NODE:
                node.textContent = replacement(node.textContent);
                break;
            case Node.DOCUMENT_NODE:
                walkThoughNode(node, replacement);
        }
    }
  }

  function replacePlacehoder(originStr, placehoders) {
    if(typeof placehoders === 'object') {
      var keys = Object.keys(placehoders);
      return keys.reduce(function(pre, key) {
        var placeholder = '{' + key + '}';
        return pre.replace(placeholder, placehoders[key]);
      }, originStr);
    }
    return originStr;
  }

  function hasPlaceholderFlag(str) {
    if(str.indexOf('{') > -1 && str.indexOf('}' > -1)) return true;
    return false;
  }

  walkThoughNode(document.querySelector('main'), function(str) {
    if(!hasPlaceholderFlag(str)) return str;
    return replacePlacehoder(str, wp_stripe_express_object_receipt);
  });
})(jQuery);