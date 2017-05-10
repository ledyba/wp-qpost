wp.api.loadPromise.done(function() {

//var post = new wp.api.models.Post({ title: 'This is a test post' });
//post.save();

window.wp_qpost = function(id) {
  var elem = document.getElementById(id);
  var text = elem.value;
  if(text.length <= 0) {
    elem.focus();
    return false;
  }
  var post = new wp.api.models.Post({
      title: new Date().toLocaleString(),
      content: text,
      status: 'publish'
    });
  var r = post.save();
  r.done(function(){
    location.reload();
  });
  return true;
};

});