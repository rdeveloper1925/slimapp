

import 'firebase/compat/auth';
import { BrowserRouter, Routes, Route } from 'react-router-dom';
import AuthGuard from './Utils/AuthGuard';
import LoginPage from './Pages/LoginPage';
import HomePage from './Pages/HomePage';

function App() {
    

  return (
    <BrowserRouter>
    <Routes>
			<Route path="/" element={<LoginPage />} />
			<Route path="/home" element={<AuthGuard><HomePage /></AuthGuard>}/>
		</Routes>
    </BrowserRouter>
  )
}

export default App
