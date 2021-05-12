import * as React from 'react';

import { Text, TextProps } from './Themed';
import { View, StyleSheet } from 'react-native';

export default function Card(props: TextProps) {
  return <View style={[props.style, { ...styles.card }]}>
         {props.children}
      </View>;
}

const styles = StyleSheet.create({
   card: {
   }
});
