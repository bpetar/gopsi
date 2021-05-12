import React, { useState } from "react";
import { createStackNavigator } from "@react-navigation/stack";
import { SearchParamList } from "./SearchParamList";
import { Button, FlatList, Text, TouchableOpacity } from "react-native";
import { Center } from "./Center";

interface SearchStackProps {}

const Stack = createStackNavigator<SearchParamList>();

function Search({ navigation }) {
  const [show, setShow] = useState(false);
  return (
    <Center>
      <Text>No completed tasks at the moment.</Text>
    </Center>
  );
}

export const SearchStack: React.FC<SearchStackProps> = ({}) => {
  return (
    <Stack.Navigator initialRouteName="Search">
      <Stack.Screen 
      name="Gopsi" 
      options={{
          headerRight: () => {
            return (
              <TouchableOpacity
                onPress={() => {
                  logout();
                }}
              >
                <Text style={{ color: 'gray', margin: 16 }}>Logout</Text>
              </TouchableOpacity>
            );
          }
        }}
      component={Search} />
    </Stack.Navigator>
  );
};
