import React, { useState } from "react";
import * as SecureStore from 'expo-secure-store';
import axios from 'axios';

type User = null | { username: string };

axios.defaults.baseURL = 'http://192.168.0.19:8000';

export const AuthContext = React.createContext<{
  user: User;
  error: string,
  setUser: (user: User) => void;
  login: (email: string, password: string) => void;
  logout: () => void;
}>({
  user: null,
  error: null,
  setUser: (user: User) => {}, 
  login: (email: string, password: string) => {},
  logout: () => {}
});

interface AuthProviderProps {}

export const AuthProvider: React.FC<AuthProviderProps> = ({ children }) => {
  const [user, setUser] = useState<User>(null);
  const [error, setError] = useState(null);
  return (
    <AuthContext.Provider
      value={{
        user,
        setUser,
        error,
        login: (email, password) => {
          axios.post('/api/airlock/token', {
            email,
            password,
            device_name: 'mobile',
          })
          .then(response => {
            const userResponse = {
              email: response.data.user.email,
              token: response.data.token,
            }
            console.log(userResponse);
            setUser(userResponse);
            setError(null);
            SecureStore.setItemAsync('user', JSON.stringify(userResponse));
          })
          .catch(error => {
            //console.log(error);
            const key = Object.keys(error.response.data.errors)[0];
            setError(error.response.data.errors[key][0]);
          })
        },
        logout: () => {
          axios.defaults.headers.common['Authorization'] = `Bearer ${user.token}`;
          axios.post('/api/logout')
          .then(response => {
            setUser(null);
            SecureStore.deleteItemAsync('user')
          })
          .catch(error => {
            console.log(error.response);
          })
        }
      }}
    >
      {children}
    </AuthContext.Provider>
  );
};
