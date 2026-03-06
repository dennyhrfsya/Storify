(function() {
var input = document.getElementById('password-current'),
        icon = document.getElementById('icon-current-password'),
        myImage = document.querySelector('#icon-current-password');

       icon.onclick = function () {

         if(input.className == 'modal-input-d form-control') {
            input.setAttribute('type', 'text');
            myImage.setAttribute ('src', 'images/eye-slash.svg');
            input.className = 'form-group modal-input-d form-control';

           } else {
              input.setAttribute('type', 'password');
              myImage.setAttribute ('src', 'images/eye.svg');
              input.className = 'modal-input-d form-control';

        }
       }
  })();

(function() {
var input = document.getElementById('password-new'),
        icon = document.getElementById('icon-new-password'),
        myImage = document.querySelector('#icon-new-password');

       icon.onclick = function () {

         if(input.className == 'modal-input-d form-control') {
            input.setAttribute('type', 'text');
            myImage.setAttribute ('src', 'images/eye-slash.svg');
            input.className = 'form-group modal-input-d form-control';

           } else {
              input.setAttribute('type', 'password');
              myImage.setAttribute ('src', 'images/eye.svg');
              input.className = 'modal-input-d form-control';

        }
       }
  })();