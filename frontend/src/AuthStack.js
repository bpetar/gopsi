
import React, { useContext, useState } from "react";
import { createStackNavigator } from "@react-navigation/stack";
import { AuthContext } from "./AuthProvider";
import { Button, Text, View, TextInput } from "react-native";

const Stack = createStackNavigator();

function LoginScreen({ navigation }) {
  const { login, error } = useContext(AuthContext);
  const [email, setEmail] = useState('');
  const [password, setPassword] = useState('');

  return (
    <View style={{ flex: 1, alignItems: 'center', justifyContent: 'center' }}>
      <Text style={{ marginBottom: 24, fontSize: 18 }}>Welocome to Gopsi</Text>
      { error &&
        <Text style={{ color: 'red', marginBottom: 24 }}>{ error }</Text>
      }
      <TextInput
        style={{ height: 40, width: 300, borderColor: 'gray', borderWidth: 1, padding: 8 }}
        onChangeText={text => setEmail(text)}
        placeholder="Email"
        textContentType="emailAddress"
        autoCapitalize = 'none'
      />
      <TextInput
        style={{ height: 40, width: 300, borderColor: 'gray', borderWidth: 1, padding: 8, marginTop: 24, marginBottom: 24 }}
        onChangeText={text => setPassword(text)}
        placeholder="Password"
        secureTextEntry={true}
      />
      <Button
        color="#91c49f"
        title="Login"
        onPress={() => login(email, password)}
      />
      <Text style={{ marginBottom: 4, marginTop: 4 }}>or</Text>
      <Text style={{color: 'blue'}} onPress={() => navigation.navigate('Register')}>
        Register
      </Text>
    </View>
  );
}

function RegisterScreen({ navigation }) {
  const { register, error } = useContext(AuthContext);
  const [email, setEmail] = useState('');
  const [name, setName] = useState('');
  const [password, setPassword] = useState('');

  return (
    <View style={{ flex: 1, alignItems: 'center', justifyContent: 'center' }}>
      <Text style={{ marginBottom: 24, padding: 8, fontSize: 18 }}>Register to Gopsi</Text>
      <Text style={{ marginBottom: 24, textAlign: 'center', paddingLeft: 28, paddingRight: 28, color: 'gray' }}>Your Gopsi trainer will use this email address to create tasks for you.</Text>
      { error &&
        <Text style={{ color: 'red', marginBottom: 24 }}>{ error }</Text>
      }
      <TextInput
        style={{ height: 40, width: 300, borderColor: 'gray', borderWidth: 1, padding: 8 }}
        onChangeText={text => setName(text)}
        placeholder="Name"
      />
      <TextInput
        style={{ height: 40, width: 300, borderColor: 'gray', borderWidth: 1, padding: 8, marginTop: 24 }}
        onChangeText={text => setEmail(text)}
        placeholder="Email"
        textContentType="emailAddress"
        autoCapitalize = 'none'
      />
      <TextInput
        style={{ height: 40, width: 300, borderColor: 'gray', borderWidth: 1, padding: 8, marginTop: 24, marginBottom: 24 }}
        onChangeText={text => setPassword(text)}
        placeholder="Password"
        secureTextEntry={true}
      />
      <Button
        color="#91c49f"
        title="    Register    "
        onPress={() => register(name, email, password)}
      />
      <Text style={{ marginBottom: 4, marginTop: 4 }}>or</Text>
      <Text style={{color: 'blue'}} onPress={() => navigation.navigate('Login')}>
        Login
      </Text>
    </View>
  );
}

export const AuthStack = () => {
  return (
    <Stack.Navigator>
      <Stack.Screen name="Login" component={LoginScreen} />
      <Stack.Screen name="Register" component={RegisterScreen} />
    </Stack.Navigator>
  )
}

/*const styles = StyleSheet.create({
  button: {
    borderRadius: 20,
    marginLeft: 10,
    marginRight: 10,
    padding: 10,
    elevation: 2
  },
  buttonClose: {
    backgroundColor: "#2196F3",
  },
  buttonTextStyle: {
    marginLeft: 10,
    marginRight: 10,
    color: "white",
    fontWeight: "bold",
    textAlign: "center"
  }
});*/