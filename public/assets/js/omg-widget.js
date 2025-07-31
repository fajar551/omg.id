// To get query params https://flaviocopes.com/urlsearchparams/
const qParams = new URLSearchParams(window.location.search);
const widgetURL = `${window.location.origin}${window.location.pathname}?`;
const styleRoot = document.querySelector(':root');

let hasRegitered = false;
let regCallbackIntv  = null;

const setStyle = (prop, value) => { 
   document.documentElement.style.setProperty(prop, value); 
}

const getStyle = (prop) => { 
  var rs = getComputedStyle(styleRoot);

  return rs.getPropertyValue(prop);
}

const setHTML = (id, html) => { 
   try {
      getElementById(id).innerHTML = html; 
   } catch (error) {
      // console.error(error);
   }
}

const setFont = (font) => {
   font = font ? font.replace(/\+/g, ' ') : "Ubuntu"; 

   setStyle('--font-family', font);
   WebFont.load({
       google: {
           families: [font]
       }
   });
}

const getElementById = (id) => { 
   return document.getElementById(id); 
}

const getElementsByClassName = (className) => { 
   return document.getElementsByClassName(className); 
}

const buildParams = (name, value) => { 
   qParams.set(name, value);
}

const getQParams = () => { 
   return qParams;
}

const getQParamsByKey = (key) => { 
   return qParams.get(key);
}

const reloadWidget = () => {
   // location.href = widgetURL +qParams.toString();
   location.replace(widgetURL +qParams.toString());
}

const toIDR = (price, decimal = 0) => { 
   price = parseInt(price || 0);
   return 'Rp' + Number(price.toFixed(decimal)).toLocaleString().replace(/\./g, "@").replace(/,/g, ".").replace(/@/g, ","); 
}

const splitLongText = (text, length = 10, split = 15) => {
   if (text.length > length) {
       text = text.substring(0, split) + '...';
   }

   return text;
}

const regCallbackInterval = (callbacks = {}) => {
   registerCallback(callbacks);
   regCallbackIntv = setInterval(() => {
         if (hasRegitered) {
            clearInterval(regCallbackIntv);
            regCallbackIntv = null;
            return;
         }

         if (parent && parent.isChildCallbackEmpty() && !hasRegitered) {
            registerCallback(callbacks);

            clearInterval(regCallbackIntv);
            regCallbackIntv = null;
         }
   }, 3 * 1000);   // 3 Seconds
}

const registerCallback = (callbacks = {}) => {
   if (parent && parent.registerChildFunction){
         console.log('registering callback with parent');

         parent.registerChildFunction({
            ...callbacks,
            "setStyle": setStyle,
            "getStyle": getStyle,
            "setHTML": setHTML,
            "setFont": setFont,
            "getElementById": getElementById,
            "getElementsByClassName": getElementsByClassName,
            "toIDR": toIDR,
            "buildParams": buildParams,
            "reloadWidget": reloadWidget,
            "getQParams": getQParams,
            "getQParamsByKey": getQParamsByKey,
         });

         parent.postMessage("childCallbacksHasRegistered", "*");
         hasRegitered = true;
   }
}