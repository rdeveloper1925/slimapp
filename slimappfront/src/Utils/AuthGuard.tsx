import { Navigate } from "react-router-dom";
import LoginPage from "../Pages/LoginPage";
import { useAuthStore } from "../Stores/Authstore";

const AuthGuard = (props) =>{
    const isLoggedIn = useAuthStore(state=>state.isLoggedIn);
    const user = useAuthStore(state=>state.user);
    console.log(isLoggedIn, user, 'logged in by authguard');
return isLoggedIn ? props.children : <LoginPage message="Please login to continue"/>;

}

export default AuthGuard;