import { Navigate } from "react-router-dom";
import LoginPage from "../Pages/LoginPage";

const AuthGuard = (props) =>{
    const isLoggedIn = false;
return isLoggedIn ? props.children : <LoginPage message="Please login to continue"/>;

}

export default AuthGuard;