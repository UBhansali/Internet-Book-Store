package sv.bookplace;

import android.content.Intent;
import android.content.SharedPreferences;
import android.preference.PreferenceManager;
import android.support.v7.app.AppCompatActivity;
import android.os.Bundle;
import android.view.View;

public class MainActivity extends AppCompatActivity {

    static final String serverURL_login = "http://192.168.1.152/project/auth/login.php";
    static final String serverURL_register = "http://192.168.1.152/project/auth/register.php";
    static final String serverURL_books = "http://192.168.1.152/project/mobile/books.php";
    static final String serverURL_query1 = "http://192.168.1.152/project/mobile/query1.php";
    static final String serverURL_query2 = "http://192.168.1.152/project/mobile/query2.php";
    static final String serverURL_query3 = "http://192.168.1.152/project/mobile/query3.php";
    static final String serverURL_years = "http://192.168.1.152/project/mobile/years.php";
    static final String serverURL_query5 = "http://192.168.1.152/project/mobile/query5.php";

    @Override
    protected void onCreate(Bundle savedInstanceState) {
        super.onCreate(savedInstanceState);
        setContentView(R.layout.activity_main);

        SharedPreferences pref = PreferenceManager.getDefaultSharedPreferences(MainActivity.this);
        if (pref.getString("auth", "").equals("true"))
        {
            Intent intent = new Intent(this, HomeActivity.class);
            startActivity(intent);
        }
    }

    public void sendLogin(View view) {
        Intent intent = new Intent(this, LoginActivity.class);
        startActivity(intent);
    }

    public void sendRegister(View view) {
        Intent intent = new Intent(this, RegisterActivity.class);
        startActivity(intent);
    }
}
