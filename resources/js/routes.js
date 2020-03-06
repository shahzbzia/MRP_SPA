import Home from './components/Home';
import About from './components/About';
import Login from './components/Login';
import Index from './components/Index';
import CreateBooking from './components/CreateBooking';
import EditProfile from './components/EditProfile';

	function getCookie(cname) {
      var name = cname + "=";
      var decodedCookie = decodeURIComponent(document.cookie);
      var ca = decodedCookie.split(';');
      for(var i = 0; i <ca.length; i++) {
        var c = ca[i];
        while (c.charAt(0) == ' ') {
          c = c.substring(1);
        }
        if (c.indexOf(name) == 0) {
          return c.substring(name.length, c.length);
        }
      }
      return "";
    }

  var locale = getCookie('lang');

  export { locale };

export default {

	mode: 'history',

	routes: [
		{
			path: '/' + locale,
			component: Index,
      name: 'landingPage',
		},
		{
			path: '/' + locale + '/about',
			component: About,
		},
    {
      path: '/' + locale + '/signin',
      component: Login,
    },
    {
      path: '/' + locale + '/room/:id/booking/create',
      name: 'book',
      component: CreateBooking,
    },
    {
      path: '/' + locale + '/edit/profile',
      component: EditProfile,
      name: 'editProfile',
    },
	]

};