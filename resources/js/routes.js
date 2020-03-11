import Index from './components/Index';
import CreateBooking from './components/CreateBooking';
import EditProfile from './components/EditProfile';
import MyBookings from './components/MyBookings';
import ExtendBooking from './components/ExtendBooking';
import PageNotFound from './components/PageNotFound';


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
      path: '/' + locale + '/room/:id/booking/create',
      name: 'book',
      component: CreateBooking,
    },
    {
      path: '/' + locale + '/edit/profile',
      component: EditProfile,
      name: 'editProfile',
    },
    {
      path: '/' + locale + '/my/bookings',
      component: MyBookings,
      name: 'myBookings',
    },
    {
      path: '/' + locale + '/room/booking/edit/:id',
      component: ExtendBooking,
      name: 'extendBooking',
    },
    {
      path: '/' + locale + '*',
      component: PageNotFound,
      name: 'pageNotFound',
    },
	]

};