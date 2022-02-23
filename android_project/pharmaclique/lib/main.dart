import 'package:flutter/material.dart';
// import 'package:webview_flutter/webview_flutter.dart';
import 'package:flutter_webview_pro/webview_flutter.dart';

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
        body: SafeArea(
          child: WebView(
            initialUrl: "http://pharmaclique.acms.org.ph",
            javascriptMode: JavascriptMode.unrestricted,
          ),
        )
      ),
    );
  }
}

// class MyApp extends StatelessWidget {
//   const MyApp({Key? key}) : super(key: key);
//   // This widget is the root of your application.
//   @override
//   Widget build(BuildContext context) {
//     return MaterialApp(
//       debugShowCheckedModeBanner: false,
//       title: 'PharmaClique',
//       home: Scaffold(
//         body: Builder(builder: (BuildContext context) {
//           return WebView(
//             initialUrl: 'https://www.xxxxxxx',
//             javascriptMode: JavascriptMode.unrestricted,
//             onWebViewCreated: (WebViewController webViewController) {
//               _controller.complete(webViewController);
//             },
//             onProgress: (int progress) {
//               print("WebView is loading (progress : $progress%)");
//             },
//             javascriptChannels: <JavascriptChannel>{
//               _toasterJavascriptChannel(context),
//             },
//             navigationDelegate: (NavigationRequest request) {
//               if (request.url.startsWith('https://www.youtube.com/')) {
//                 print('blocking navigation to $request}');
//                 return NavigationDecision.prevent;
//               }
//               print('allowing navigation to $request');
//               return NavigationDecision.navigate;
//             },
//             onPageStarted: (String url) {
//               print('Page started loading: $url');
//             },
//             onPageFinished: (String url) {
//               print('Page finished loading: $url');
//             },
//             gestureNavigationEnabled: true,
//             geolocationEnabled: false,//support geolocation or not
//           );
//         }),
//       ),
//     );
//   }
// }
//
