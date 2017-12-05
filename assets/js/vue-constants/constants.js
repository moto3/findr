export const numbers = () => {
  var data_numbers = [];
  for(var i=1; i <= 99; i++){
    data_numbers.push({digit:i, value:i});
  }
  return data_numbers;
}
export const alphabets = () => {
  var data_alphabets = [];
  var str_alphabets = "ABCDEFGHIJKLMNOPQRSTUVWXYZ";
  for(var i=0; i < str_alphabets.length; i++){
    data_alphabets.push({letter:str_alphabets.charAt(i), value:str_alphabets.charAt(i)});
  }
  return data_alphabets;
}