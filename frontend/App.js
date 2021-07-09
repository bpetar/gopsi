import { Providers } from './src/Providers';

export default Providers;

/*
import React, { useState } from 'react';
import { View, Text, Image, ScrollView, Button, TextInput } from 'react-native';
import AsyncStorage from '@react-native-async-storage/async-storage';
import axios from 'axios';
import { NavigationContainer } from '@react-navigation/native';
import { createBottomTabNavigator } from '@react-navigation/bottom-tabs';

import { FontAwesomeIcon } from '@fortawesome/react-native-fontawesome'
import { faCoffee } from '@fortawesome/free-solid-svg-icons'
import { faCheckSquare } from '@fortawesome/free-solid-svg-icons'

const Tab = createBottomTabNavigator();


axios.defaults.baseURL = 'http://192.168.0.146:8000';

const storeData = async (value) => {
  try {
    await AsyncStorage.setItem('@storage_Key', value)
  } catch (e) {
    // saving error
    console.log("saving error sonny");
  }
}

const login = async (email, password) => {
  axios.post('/api/airlock/token', {
    email,
    password,
    device_name: 'mobile',
  })
  .then(response => {
    const userResponse = {
      email: response.data.user.email,
      token: response.data.token,
      id: response.data.user.id,
    }
    console.log(userResponse);
    //setUser(userResponse);
    //setError(null);
    //SecureStore.setItemAsync('user', JSON.stringify(userResponse));
  })
  .catch(error => {
    console.log(error);
    //const key = Object.keys(error.response.data.errors)[0];
    //setError(error.response.data.errors[key][0]);
  })
}

const Cat = (props) => {
  const [isHungry, setIsHungry] = useState(true);

  return (
    <View>
      <Text>Catllo, I am {props.name}! I am {isHungry ? "hungry!!" : "full.."}</Text>
      <Button
        onPress={() => {
          setIsHungry(false);
          storeData('mackaa');
          login('bundevica@gmail.com','polka123');
          console.log("store sonny: macka");
        }}
        disabled={!isHungry}
        title={isHungry ? "Pour me some milk, please!" : "Thank you!"}
      />
    </View>
  );
}

const HomeScreen = () => {
  console.log("new app sonny");
  storeData('pas');
  const [text, setText] = useState('');
  const [data, setData] = useState('');

  const getAsyncData = async () => {
    try {
      const value = await AsyncStorage.getItem('@storage_Key')
      if (value !== null) {
        // value previously stored
        console.log("reading sonny: " + value);
        setData(value);
        return;
      }
    } catch(e) {
      // error reading value
      console.log("reading error sonny");
    }

    setData("none bre");
  }

  const setBabe = async (valki) => {
    
    //storeData(valki);
    getAsyncData();
  }

  return (
    <ScrollView>
      <Text>Some text</Text>
      <FontAwesomeIcon icon={ faCoffee } />
      <View>
        <Text>Some more text</Text>
        <Image
          source={{
            uri: 'https://reactnative.dev/docs/assets/p_cat2.png',
          }}
          style={{ width: 200, height: 200 }}
        />
      </View>
      <Cat name="Maru"/>
      <Cat name="Bibi"/>
      <TextInput
        style={{
          height: 40,
          borderColor: 'gray',
          borderWidth: 1
        }}
        defaultValue="You can type in me"
        placeholder="Type here to translate!"
        onChangeText={text => setBabe(text)}
        defaultValue={text}
      />
      <Text style={{padding: 10, fontSize: 42}}>
        {data}
      </Text>
    </ScrollView>
  );
}

const SettingsScreen = () => {
  console.log("new app sonny");
  storeData('pas');
  const [text, setText] = useState('');
  const [data, setData] = useState('');

  const getAsyncData = async () => {
    try {
      const value = await AsyncStorage.getItem('@storage_Key')
      if (value !== null) {
        // value previously stored
        console.log("reading sonny: " + value);
        setData(value);
        return;
      }
    } catch(e) {
      // error reading value
      console.log("reading error sonny");
    }

    setData("none bre");
  }

  const setBabe = async (valki) => {
    
    //storeData(valki);
    getAsyncData();
  }

  return (
    <ScrollView>
      <Text>Some text</Text>
      <FontAwesomeIcon icon={ faCheckSquare } color={ 'red' } />
      <View>
        <Text>Some more text</Text>
        <Image
          source={{
            uri: 'https://reactnative.dev/docs/assets/p_cat2.png',
          }}
          style={{ width: 200, height: 200 }}
        />
      </View>
      <TextInput
        style={{
          height: 40,
          borderColor: 'gray',
          borderWidth: 1
        }}
        defaultValue="You can type in me"
        placeholder="Type here to translate!"
        onChangeText={text => setBabe(text)}
        defaultValue={text}
      />
      <Text style={{padding: 10, fontSize: 42}}>
        {data}
      </Text>
    </ScrollView>
  );
}

const App = () => {
  return (
    <NavigationContainer>
      <Tab.Navigator
        screenOptions={({ route }) => ({
          tabBarIcon: ({ focused, color, size }) => {
            let iconName;

            if (route.name === 'Home') {
              iconName = faCheckSquare;
            } else if (route.name === 'Settings') {
              iconName = faCoffee;
            }

            // You can return any component that you like here!
            //return <Ionicons name={iconName} size={size} color={color} />;
            return <FontAwesomeIcon icon={ iconName } color={ color } />
          },
        })}
        tabBarOptions={{
          activeTintColor: 'tomato',
          inactiveTintColor: 'gray',
        }}
        >
        <Tab.Screen name="Home" component={HomeScreen} />
        <Tab.Screen name="Settings" component={SettingsScreen} />
      </Tab.Navigator>
    </NavigationContainer>
  );
}

export default App;
*/