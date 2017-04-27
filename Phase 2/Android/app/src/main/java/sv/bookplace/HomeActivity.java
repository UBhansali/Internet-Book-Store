package sv.bookplace;

import android.support.v4.app.Fragment;
import android.content.Intent;
import android.content.SharedPreferences;
import android.os.Bundle;
import android.preference.PreferenceManager;
import android.support.v4.app.FragmentTransaction;
import android.support.design.widget.NavigationView;
import android.support.v4.view.GravityCompat;
import android.support.v4.widget.DrawerLayout;
import android.support.v7.app.ActionBarDrawerToggle;
import android.support.v7.app.AppCompatActivity;
import android.support.v7.widget.Toolbar;
import android.view.Menu;
import android.view.MenuItem;

/* Uses Navigation Drawer pre-generated template (as provided by Android Studio). */

public class HomeActivity extends AppCompatActivity
        implements NavigationView.OnNavigationItemSelectedListener {

    @Override
    protected void onCreate(Bundle savedInstanceState) {
        super.onCreate(savedInstanceState);
        setContentView(R.layout.activity_home);
        Toolbar toolbar = (Toolbar) findViewById(R.id.toolbar);
        setSupportActionBar(toolbar);

        DrawerLayout drawer = (DrawerLayout) findViewById(R.id.drawer_layout);
        ActionBarDrawerToggle toggle = new ActionBarDrawerToggle(
                this, drawer, toolbar, R.string.navigation_drawer_open, R.string.navigation_drawer_close);
        drawer.setDrawerListener(toggle);
        toggle.syncState();

        NavigationView navigationView = (NavigationView) findViewById(R.id.nav_view);
        navigationView.setNavigationItemSelectedListener(this);

        Fragment fg = new defaultview();
        FragmentTransaction ft_tr = getSupportFragmentManager().beginTransaction();
        ft_tr.replace(R.id.content_frame, fg);
        ft_tr.commit();
    }

    @Override
    public void onBackPressed() {
        DrawerLayout drawer = (DrawerLayout) findViewById(R.id.drawer_layout);
        if (drawer.isDrawerOpen(GravityCompat.START)) {
            drawer.closeDrawer(GravityCompat.START);
        } else {
            super.onBackPressed();
        }
    }

    @Override
    public boolean onCreateOptionsMenu(Menu menu) {
        getMenuInflater().inflate(R.menu.home, menu);
        return true;
    }

    @Override
    public boolean onOptionsItemSelected(MenuItem item) {
        int id = item.getItemId();

        if (id == R.id.action_signout)
        {
            SharedPreferences.Editor pref = PreferenceManager.getDefaultSharedPreferences(this).edit();
            pref.remove("auth");
            pref.remove("token");
            pref.apply();
            Intent intent = new Intent(this, MainActivity.class);
            startActivity(intent);
        }

        return super.onOptionsItemSelected(item);
    }

    private void showView(int id)
    {
        Fragment fg = null;
        if (id == R.id.defaultview) {
            fg = new defaultview();
        }
        else if (id == R.id.query1)
            fg = new query1();
        else if (id == R.id.query2)
            fg = new query2();
        else if (id == R.id.query3)
            fg = new query3();
        else if (id == R.id.query5)
            fg = new query5();

        if (fg != null)
        {
            FragmentTransaction ft_tr = getSupportFragmentManager().beginTransaction();
            ft_tr.replace(R.id.content_frame, fg);
            ft_tr.commit();
        }
        DrawerLayout drawer = (DrawerLayout) findViewById(R.id.drawer_layout);
        drawer.closeDrawer(GravityCompat.START);
    }

    @SuppressWarnings("StatementWithEmptyBody")
    @Override
    public boolean onNavigationItemSelected(MenuItem item) {
        int id = item.getItemId();
        Toolbar toolbar = (Toolbar) findViewById(R.id.toolbar);

        if (id == R.id.defaultview) {
            toolbar.setTitle("BookPlace");
            this.showView(item.getItemId());
        } else if (id == R.id.query1) {
            toolbar.setTitle("Query 1");
            this.showView(item.getItemId());
        } else if (id == R.id.query2) {
            toolbar.setTitle("Query 2");
            this.showView(item.getItemId());
        } else if (id == R.id.query3) {
            toolbar.setTitle("Query 3");
            this.showView(item.getItemId());
        } else if (id == R.id.query5) {
            toolbar.setTitle("Query 5");
            this.showView(item.getItemId());
        }

        DrawerLayout drawer = (DrawerLayout) findViewById(R.id.drawer_layout);
        drawer.closeDrawer(GravityCompat.START);
        return true;
    }
}
