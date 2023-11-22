function setreferrer_cookie(){
	var referrer_value = escape(document.referrer);
        var search_value = window.location.search;
        if(search_value != '') {
                var cookiename = '';
                cookiename = window.location.search.split("?")[1];
                cookiename = cookiename.split("&")[0];
                var lifeTime = new Date();
                // alert(lifeTime);
                lifeTime.setTime(lifeTime.getTime() + (90*24*60*60*1000));
                // document.cookie = "sourceURL="+cookiename+";expires="+lifeTime.toGMTString()+";path=/;domain=topremotestaff.com";
                document.cookie = "sourceURL="+cookiename+";expires="+lifeTime.toGMTString()+";path=/";
        }
}


function getCookie(cookieName) {
        let cookies = document.cookie;
        let cookieArray = cookies.split("; ");

        for (let i = 0; i < cookieArray.length; i++) {
                let cookie = cookieArray[i];
                let [name, value] = cookie.split("=");

                if (name === cookieName) {
                        return decodeURIComponent(value);
                }
        }

        return null;
}

function clear_localStorage() {
        var newURL = window.location.href;
        pathArray = newURL.split( '/' );
        var currentPage = pathArray[pathArray.length-1];
        if (currentPage != 'exam.php'){
                localStorage.removeItem("timeleft");
        }
}

// document.addEventListener("load", setreferrer_cookie());

// window.onload=function(){
//         setreferrer_cookie();
//         clear_localStorage();
// }
