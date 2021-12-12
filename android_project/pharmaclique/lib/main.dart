import 'package:flutter/material.dart';
import 'package:webview_flutter/webview_flutter.dart';

void main() {
  runApp(const MyApp());
}

class MyApp extends StatelessWidget {
  const MyApp({Key? key}) : super(key: key);
  // This widget is the root of your application.
  @override
  Widget build(BuildContext context) {
    return MaterialApp(
      debugShowCheckedModeBanner: false,
      title: 'PharmaClique',
      home: Scaffold(
        body: WebView(
          initialUrl: "http://pharmaclique.acms.org.ph",
          javascriptMode: JavascriptMode.unrestricted,
        ),
      ),
    );
  }
}