import React, { useContext } from "react";
import { createBottomTabNavigator } from "@react-navigation/bottom-tabs";
import { Text, ScrollView } from 'react-native';
import { FontAwesomeIcon } from '@fortawesome/react-native-fontawesome'
import { faCheckSquare } from '@fortawesome/free-solid-svg-icons'
import { faHome } from '@fortawesome/free-solid-svg-icons'
import { HomeStack } from "./HomeStack";
import { DoneStack } from "./DoneStack";

const Tabs = createBottomTabNavigator();

export const AppTabs = () => {
  return (
    <Tabs.Navigator
      screenOptions={({ route }) => ({
        tabBarIcon: ({ focused, color, size }) => {
          let iconName;

          if (route.name === "Active") {
            iconName = "home";
            //return <AntDesign name={"home"} size={size} color={color} />;
            return <FontAwesomeIcon color={color} size={size} icon={ faHome } />
          } else {
            //return <AntDesign name={"checkcircleo"} size={size} color={color} />;
            return <FontAwesomeIcon color={color} size={size-5} icon={ faCheckSquare } />
          }
        }
      })}
      tabBarOptions={{
        activeTintColor: "#91c49f",
        inactiveTintColor: "gray"
      }}
    >
      <Tabs.Screen name="Active" component={HomeStack} />
      <Tabs.Screen name="Done" component={DoneStack} />
    </Tabs.Navigator>
  );
};
