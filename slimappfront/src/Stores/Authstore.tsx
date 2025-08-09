import { create } from 'zustand';
import {persist, createJSONStorage} from 'zustand/middleware';

export type User={
    uid: string,
    email: string,
    name?: string | null,
    photo?: string | null,
    providerId?: string| null
}

const emptyUser: User = {
    uid: '',
    email: '',
    name: null,
    photo: null,
    providerId: null,
} 

export const useAuthStore = create(persist((set)=>
    ({
        user: emptyUser,
        isLoggedIn:false,
        setUser: (user: User)=>set({user}),
        setLoggedIn: (loginState : boolean)=>set({isLoggedIn: loginState}),
        clearUser: () => set({user:emptyUser, isLoggedIn: false})
    }),{
        name: 'slim-app-store',
        storage: createJSONStorage(() => localStorage)
    }));

// window.addEventListener('storage', (event) => {
//   if (event.key === 'slim-app-store') {
//     const newState = event.newValue ? JSON.parse(event.newValue).state : null;
//     if (newState) {
//       useAuthStore.setState(newState);
//     }
//   }
// });
// window.addEventListener('storage', (event) => {
//   if (event.key === 'slim-app-store' && event.newValue) {
//     const newState = JSON.parse(event.newValue).state;
//     const currentState = useAuthStore.getState();

//     const hasChanged = JSON.stringify(newState) !== JSON.stringify(currentState);

//     if (hasChanged) {
//       useAuthStore.setState(newState, true); // true = replace entire state
//     }
//   }
// });
