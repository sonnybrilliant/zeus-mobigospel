/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

package org.mobilitate.hermes.client;

import java.util.regex.Matcher;
import java.util.regex.Pattern;

/**
 *
 * @author ronald
 */
public class Util {

  public static boolean isNumeric(String number)
  {
    boolean isValid = false;
    /*Explaination:
     [-+]?: Can have an optional - or + sign at the beginning.
     [0-9]*: Can have any numbers of digits between 0 and 9
     \\.? : the digits may have an optional decimal point.
     [0-9]+$: The string must have a digit at the end.
     If you want to consider x. as a valid number change
     the expression as follows. (but I treat this as an invalid number.).
     String expression = "[-+]?[0-9]*\\.?[0-9\\.]+$";
    */
    String expression = "[-+]?[0-9]*\\.?[0-9]+$";
    CharSequence inputStr = number;
    Pattern pattern = Pattern.compile(expression);
    Matcher matcher = pattern.matcher(inputStr);

    if(matcher.matches()){
      isValid = true;
    }

    return isValid;
  }

  public static boolean isEmailValid(String email)
  {
    boolean isValid = false;

    /*
     Email format: A valid email address will have following format:
        [\\w\\.-]+: Begins with word characters, (may include periods and hypens).
	@: It must have a '@' symbol after initial characters.
	([\\w\\-]+\\.)+: '@' must follow by more alphanumeric characters (may include hypens.).
     This part must also have a "." to separate domain and subdomain names.
	[A-Z]{2,4}$ : Must end with two to four alaphabets.
     (This will allow domain names with 2, 3 and 4 characters e.g pa, com, net, wxyz)

     Examples: Following email addresses will pass validation
     abc@xyz.net; ab.c@tx.gov
     */

     //Initialize reg ex for email.
     String expression = "^[\\w\\.-]+@([\\w\\-]+\\.)+[A-Z]{2,4}$";
     CharSequence inputStr = email;
     //Make the comparison case-insensitive.
     Pattern pattern = Pattern.compile(expression,Pattern.CASE_INSENSITIVE);
     Matcher matcher = pattern.matcher(inputStr);
      if(matcher.matches()){
        isValid = true;
      }
    return isValid;
  }

}
