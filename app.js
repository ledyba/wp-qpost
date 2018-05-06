wp.api.loadPromise.done(function() {

//var post = new wp.api.models.Post({ title: 'This is a test post' });
//post.save();

window.wp_qpost = function(btn, form) {
  var text = form.value;
  if(text.length <= 0) {
    form.focus();
    return false;
  }
  var post = new wp.api.models.Post({
      content: text,
      status: 'publish'
    });
  var parent = btn.getParent();
  parent.removeChild(btn);
  var r = post.save();
  r.done(function(){
    form.value='';
    location.reload();
  })
  .fail(function(){
    parent.appendChild(btn);
  });
  return true;
};

});
