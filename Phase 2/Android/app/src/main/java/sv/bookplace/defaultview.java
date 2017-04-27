package sv.bookplace;

import android.content.Context;
import android.content.DialogInterface;
import android.support.annotation.IdRes;
import android.support.annotation.LayoutRes;
import android.support.v4.app.Fragment;
import android.os.Bundle;
import android.support.annotation.Nullable;
import android.support.v7.app.AlertDialog;
import android.util.Log;
import android.view.LayoutInflater;
import android.view.View;
import android.view.ViewGroup;
import android.widget.Button;
import android.widget.CheckBox;
import android.widget.ListView;
import android.widget.SimpleAdapter;

import com.android.volley.Request;
import com.android.volley.RequestQueue;
import com.android.volley.Response;
import com.android.volley.VolleyError;
import com.android.volley.toolbox.StringRequest;
import com.android.volley.toolbox.Volley;

import org.json.JSONArray;
import org.json.JSONException;
import org.json.JSONObject;

import java.util.ArrayList;
import java.util.HashMap;
import java.util.List;
import java.util.Map;

public class defaultview extends Fragment {

    ArrayList<String> list;
    double totalPrice = 0.0;

    @Nullable
    @Override
    public View onCreateView(LayoutInflater inflater, @Nullable ViewGroup container, @Nullable Bundle savedInstanceState) {
        return inflater.inflate(R.layout.defaultview, container, false);
    }

    @Override
    public void onViewCreated(View view, @Nullable Bundle savedInstanceState) {
        super.onViewCreated(view, savedInstanceState);
        getActivity().setTitle("BookPlace ($0.00)");

        final ListView lstView = (ListView) getView().findViewById(R.id.defaultView_listview);

        StringRequest stringRequest = new StringRequest(Request.Method.GET, MainActivity.serverURL_books,
                new Response.Listener<String>() {
                    @Override
                    public void onResponse(String response) {
                        try {
                            JSONArray jarray = new JSONArray(response);
                            list = new ArrayList<>();
                            ArrayList<HashMap<String, String>> lst = new ArrayList<>();

                            for (int i = 0; i < jarray.length(); i++) {
                                HashMap<String, String> hm = new HashMap<>();
                                hm.put("title", (new JSONObject(jarray.get(i).toString())).getString("title"));
                                hm.put("author", (new JSONObject(jarray.get(i).toString())).getString("author_list"));
                                hm.put("isbn", (new JSONObject(jarray.get(i).toString())).getString("ISBN13"));
                                hm.put("price", (new JSONObject(jarray.get(i).toString())).getString("price"));
                                lst.add(hm);
                            }

                            String[] from = {"title", "author" };
                            int[] to = {R.id.title, R.id.subitem};

                            rowAdapter simpleAdapter = new rowAdapter(getActivity().getApplicationContext(), lst, R.layout.row, from, to, list);

                            lstView.setAdapter(simpleAdapter);
                        } catch (JSONException e) {
                            e.printStackTrace();
                        }
                    }
                },
                new Response.ErrorListener() {
                    @Override
                    public void onErrorResponse(VolleyError error) {
                    }
                }) {

            @Override
            protected Map<String, String> getParams() {
                Map<String, String> parameters = new HashMap<>();
                parameters.put("auth_name", "Kevin Garnett");
                return parameters;
            }
        };

        RequestQueue requestQueue = Volley.newRequestQueue(getActivity().getApplicationContext());
        requestQueue.add(stringRequest);

        Button chkButtn = (Button) getView().findViewById(R.id.checkoutButton);
        chkButtn.setOnClickListener(new View.OnClickListener() {
            @Override
            public void onClick(View view) {
                if (list.size() > 0) {
                    AlertDialog.Builder dialog = new AlertDialog.Builder(getActivity());
                    dialog.setCancelable(false);
                    dialog.setTitle("Thank You");
                    dialog.setMessage("Thank you for purchasing " + list.size() + (list.size() == 1
                            ? " book" : " books") + ", for a total of $" + String.format("%.2f", totalPrice) + ".");
                    dialog.setPositiveButton("Finish", new DialogInterface.OnClickListener() {
                        @Override
                        public void onClick(DialogInterface dialog, int id) {
                            dialog.dismiss();
                        }
                    });

                    final AlertDialog alert = dialog.create();
                    alert.show();
                }
            }
        });
    }

    private class rowAdapter extends SimpleAdapter {
        private LayoutInflater inflater = null;
        ArrayList<String> list;
        Context context;
        List tmp;

        public rowAdapter(Context context, List<? extends Map<String, ?>> data,
                          @LayoutRes int resource, String[] from, @IdRes int[] to, ArrayList<String> list)
        {
            super(context, data, resource, from, to);
            this.context = context;
            this.list = list;
            this.tmp = data;
            inflater = LayoutInflater.from(context);
        }


        @Override
        public View getView(final int position, View convertView, ViewGroup parent) {
            View view = super.getView(position, convertView, parent);
            final CheckBox cb = (CheckBox) view.findViewById(R.id.itemsCheck);
            cb.setOnClickListener(new View.OnClickListener() {
                @Override
                public void onClick(View v) {
                    String isbn = ((HashMap<String, String>)tmp.get(position)).get("isbn");
                    if (cb.isChecked()) {
                        list.add(isbn);
                        totalPrice += Double.parseDouble(((HashMap<String, String>)tmp.get(position)).get("price"));
                    }
                    else {
                        list.remove(isbn);
                        totalPrice -= Double.parseDouble(((HashMap<String, String>)tmp.get(position)).get("price"));
                    }
                    Log.d(",", Integer.toString(list.size()));

                    getActivity().setTitle("BookPlace ($" + String.format("%.2f", totalPrice) + ")");
                }
            });

            return view;
        }
    }
}
