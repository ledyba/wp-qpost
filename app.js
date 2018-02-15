wp.api.loadPromise.done(function() {

//var post = new wp.api.models.Post({ title: 'This is a test post' });
//post.save();

window.wp_qpost = function(btn, form, force, event) {
  if(!force) {
    console.log(event);
    return false;
  }
  var text = form.value;
  if(text.length <= 0) {
    form.focus();
    return false;
  }
  var post = new wp.api.models.Post({
      title: new Date().toLocaleString(),
      content: text,
      status: 'publish'
    });
  var parent = btn.getParent();
  parent.removeChild(btn);
  var r = post.save();
  r.done(function(){
    location.reload();
  })
  .fail(function(){
    parent.appendChild(btn);
  });
  return true;
};

});
