let childCallbacks = {};

function registerChildFunction(callback){
   childCallbacks = callback;
}

function isChildCallbackEmpty() {
   return Object.keys(childCallbacks).length === 0;
}