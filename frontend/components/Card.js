import * as React from 'react';

import { View, StyleSheet } from 'react-native';

export default function Card(props) {
  return <View style={[props.style, { ...styles.card }]}>
         {props.children}
      </View>;
}

const styles = StyleSheet.create({
   card: {
   }
});
