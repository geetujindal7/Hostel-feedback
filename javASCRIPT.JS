function firstfocus()
  {
  var uid = document.registration.userid.focus();
  return true;
  }

  function userid_validation(mx,my)
  {
  var uid = document.registration.userid;
  var uid_len = uid.value.length;
  if (uid_len == 0 || uid_len >= my || uid_len < mx)
  {
  alert("User Id should not be empty / length be between "+mx+" to "+my);
  uid.focus();
  return false;
  }

  function ValidateEmail()
 {
 var uemail = document.registration.eid;
 var mailformat = /^\w+([\.-]?\w+)*@\w+([\.-]?\w+)*(\.\w{2,3})+$/;
 if(uemail.value.match(mailformat))
 {
 document.registration.desc.focus();
 return true;
 }
 else
 {
 alert("You have entered an invalid email address!");
 uemail.focus();
 return false;
 }
 }

 function allLetter()
  {
  var uname = document.registration.name;
  var letters = /^[A-Za-z]+$/;
  if(uname.value.match(letters))
  {
  // Focus goes to next field i.e. Address.
  document.registration.address.focus();
  return true;
  }
  else
  {
  alert('Username must have alphabet characters only');
  uname.focus();

  return false;
  }
  }


  function userSession_validation(mx,my)
  {
  var uid = document.registration.userid;
  var uid_len = uid.value.length;
  if (uid_len == 0 || uid_len >= my || uid_len < mx)
  {
  alert("User Id should not be empty / length be between "+mx+" to "+my);
  uid.focus();
  return false;
  }

}
