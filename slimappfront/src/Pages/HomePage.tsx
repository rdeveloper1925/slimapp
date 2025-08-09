import { useAuthStore } from "../Stores/Authstore";
const HomePage = () =>{
    console.log('state', useAuthStore.getState());
    return (
    <>
      <h1>Welcome home
    </h1>
    <button className="btn btn-danger btn-md" onClick={()=>useAuthStore.getState().clearUser()}>Logout</button>
    </>
  )
}

export default HomePage;