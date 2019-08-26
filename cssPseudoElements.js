(function($) {
	/*
   * cssPseudo - Pseudo Class Adder (jQuery)
   *
   * @author BananaAcid / Nabil Redmann
   * @version 2.1.0
   * @url https://jsfiddle.net/BananaAcid/96rdevhp/
   * @description
   *    use as `.cssPseudo('hover', {...})` or `.cssPseudo('after', {...})` (like you would use `.css({...})`)  to set.
   *			Note: using `hover:after` will not match `hover::after` on this plugin (you have to use the same spelling throughout your code),
   *			but the browser will use the double version and the css will work.
   *
   *    To clear, use 
   *			Use `.cssPseudo(false)` [or `null`] to clear all added pseudo css for that element.
   *    	->(pseudoClass, null/false/"", customSelectorString) -> second param must not be an object, but either null, false or an empty string.
   *			(n/f/'') -> clear all pseudos (pseudo must not be `undefined`), e.g. `.cssPseudo(false)`
   *			(pc, n/f/'') -> clear all of that pseudo, e.g. `.cssPseudo('after', false)`
   *			(pc, n/f/'', customSelectorString) -> clear only pseudoClass with specific customSelectorString, e.g. `.cssPseudo('after', false, '%s.error')`
   *			(n/f/'', n/f/'', customSelectorString) -> clear any pseudoClass with specific customSelectorString, e.g. `.cssPseudo(false, false, '%s.error')`
   *			
   *    To add the selector only, without any pseudo class, just pass null or false as `pseudClass` param.
   *
   *    jQuery will not add empty properties to the css. We need to enforce the quotes on `content` like `{content: '""', ..}`. Also for `content: 'attr(title) ", text"'`
   *
   *    To get a css property use something like `.cssPseudo('after', 'background-color')`.
   *			For multiple rules, only the last occuring value will be used. `{top: 20}` will be returned as `20px`!
   *			Make sure, you use the same `customSelectorString` param again, if any.
   *
   *    `.css()` will overrule `.cssPseudo()` since `.css()` will add to the elements style, and `.cssPseudo()` to the stylesheet. 
   *
   *    `customSelectorString` can be used to provide another selector, %s will be replaced with the current elements unique selector.
   *			`$('selector').cssPseudo('before', { ... }, '%s.error')` will work like `selector.error::before`. 
   *			The unique identifier part of this plugin, will be added to the selector, that is why `%s` is needed and you can not just enter the selector again.
   *      If you omit the %s but specify a selector, the %s will be prepended internally - so '.error' results in '%s.error' for the error class.
   */
  $.fn.cssPseudo = function(pseudoClass, cssObject, customSelectorString) {
      var sheet = ($.cssPseudo || {}).sheet || document.styleSheets[0],  //  use $.cssPseudo.createSeperateStylesheet() to create a seperate style sheet
          $self = this,
          customSelectorStringTpl = customSelectorString ? ( !~customSelectorString.indexOf('%s') ? '%s' + customSelectorString : customSelectorString ) : '%s',
          result = false;

      // clear statements, the user must set it to a string or to false
      if (pseudoClass === undefined) throw new Error('pseudoClass must not be undefined');
      // normalize
      var psCl = (pseudoClass === false || pseudoClass === null || pseudoClass === '') ? null : (pseudoClass && pseudoClass.trim() ? pseudoClass.trim() : null);    
      // clear statements, the user must set it to an object or to false
      if (psCl !== null && cssObject === undefined) throw new Error('cssObject must not be undefined, when pseudoClass is defined'); 
      // normalize
      cssObject = (cssObject !== false && cssObject !== null && cssObject !== undefined && cssObject !== '') ? cssObject : null;

      // iterate all jQuery-selected elements
      this.each(function () {
          var d = $(this).data('css-pseudos');

          if (!d) {
              $(this).data('css-pseudos', d = []);
          }
          if (cssObject && typeof cssObject !== 'string') { // is object, add
              var uid = $(this).attr('data-css-pseudo-uid'); 
              if (!uid) $(this).attr('data-css-pseudo-uid', uid = window.performance && window.performance.now && window.performance.timing && window.performance.timing.navigationStart ? window.performance.now() + window.performance.timing.navigationStart : Date.now() );
              var parsedCss = $('<css-pseudo-temp>').css(cssObject).attr('style'), cssStr;
              var idx = sheet.insertRule( cssStr = customSelectorStringTpl.replace('%s', '[data-css-pseudo-uid="'+uid+'"]')  + (psCl ? ':' + psCl : '') + ' { ' + parsedCss  + ' }');
              var rule = sheet.rules[idx];
              d.push({pseudoClass: psCl, customSelectorString: customSelectorString, rule: rule });
              //console.log('rules length: ', sheet.rules.length, '-- cssStr:', cssStr);
          }
          else if (typeof cssObject == 'string') { // is string
              // only last value is used.
              result = undefined;
              $(d).each(function(i) {
                  if (this.pseudoClass == psCl && this.customSelectorString == customSelectorString)
                      result = $('<css-pseudo-temp>').attr('style', this.rule.cssText.match(/{(.+)}/).pop() ).css(cssObject); // only last value is used.
              });
          }
          else { // remove -> cssObject === null
              var ret = $(d).filter(function(i) {
                  if ( (psCl === null || this.pseudoClass == psCl)  &&  (!customSelectorString || this.customSelectorString == customSelectorString) ) {
                      var idx = $.inArray(this.rule, sheet.rules);
                      if (idx !== -1)
                          sheet.deleteRule(idx);
                      return false; // remove rule from knonwn ones
                  }
                  return true; // keep rule
              });
              if (ret.length) // some rules are left over
                  $(this).data('css-pseudos', ret);
              else {
                  $(this).removeData('css-pseudos');
                  $(this).removeAttr('data-css-pseudo-uid');
              }
          }
      });
      return result !== false ? result : this; // we went into getting a value, so no elements will be returned but a string
  };
  /*
   * configure the cssPseudo plugin
   */
  $.cssPseudo = {
      sheet: document.styleSheets[0], // internally used
      /**
       * automatically create a style element, or use one provided by the `optionalCreatedStylesheetElement` param
       */
      createSeperateStylesheet: function $_cssPseudo_createSeperateStylesheet(optionalCreatedStylesheetElement) {
          this.sheet = (optionalCreatedStylesheetElement || $('<style ref="cssPseudo">').appendTo('head').get(0)).sheet;
      }
  }
  // The below polyfill will bring support to IE5-IE8.
  // https://developer.mozilla.org/en-US/docs/Web/API/CSSStyleSheet/deleteRule
  if (!CSSStyleSheet.prototype.deleteRule) CSSStyleSheet.prototype.deleteRule = CSSStyleSheet.prototype.removeRule;
  if (!CSSStyleSheet.prototype.insertRule) CSSStyleSheet.prototype.insertRule = CSSStyleSheet.prototype.addRule;
})(jQuery);