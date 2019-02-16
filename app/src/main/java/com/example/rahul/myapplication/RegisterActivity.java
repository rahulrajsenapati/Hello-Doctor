package com.example.rahul.myapplication;

import android.app.ProgressDialog;
import android.content.Intent;
import android.support.annotation.NonNull;
import android.support.v7.app.AppCompatActivity;
import android.os.Bundle;
import android.text.TextUtils;
import android.view.View;
import android.widget.Button;
import android.widget.CheckBox;
import android.widget.CompoundButton;
import android.widget.EditText;
import android.widget.TextView;
import android.widget.Toast;

import com.google.android.gms.tasks.OnCompleteListener;
import com.google.android.gms.tasks.Task;
import com.google.firebase.auth.AuthResult;
import com.google.firebase.auth.FirebaseAuth;
import com.google.firebase.database.FirebaseDatabase;

import org.w3c.dom.Text;

public class RegisterActivity extends AppCompatActivity {

    EditText editTextName, editTextEmail, editTextPassword;
    Button buttonRegister;
    CheckBox patientCheckBox, doctorCheckBox;
    TextView textViewSignin;
    ProgressDialog progressDialog;

    private FirebaseAuth firebaseAuth;

    String type;

    @Override
    protected void onCreate(Bundle savedInstanceState) {
        super.onCreate(savedInstanceState);
        setContentView(R.layout.activity_register);

        firebaseAuth = FirebaseAuth.getInstance();
        progressDialog = new ProgressDialog(this);

        editTextName = findViewById(R.id.editTextName);
        editTextEmail = findViewById(R.id.editTextEmail);
        editTextPassword = findViewById(R.id.editTextPassword);
        buttonRegister = findViewById(R.id.buttonRegister);
        patientCheckBox = findViewById(R.id.patientCheckBox);
        doctorCheckBox = findViewById(R.id.doctorCheckBox);
        textViewSignin = findViewById(R.id.textViewSignin);

        patientCheckBox.setOnCheckedChangeListener(new CompoundButton.OnCheckedChangeListener() {
            @Override
            public void onCheckedChanged(CompoundButton buttonView, boolean isChecked) {
                if (isChecked) {
                    type = "patient";
                }else type = "";
            }
        });

        doctorCheckBox.setOnCheckedChangeListener(new CompoundButton.OnCheckedChangeListener() {
            @Override
            public void onCheckedChanged(CompoundButton buttonView, boolean isChecked) {
                if (isChecked) {
                    type = "doctor";
                }else type = "";
            }
        });

        textViewSignin.setOnClickListener(new View.OnClickListener() {
            @Override
            public void onClick(View v) {
                startActivity(new Intent(RegisterActivity.this, MainActivity.class));
            }
        });

        buttonRegister.setOnClickListener(new View.OnClickListener() {
            @Override
            public void onClick(View v) {
                final String name = editTextName.getText().toString();
                final String email = editTextEmail.getText().toString();
                String password = editTextPassword.getText().toString();

                String ready = "true";
                if (TextUtils.isEmpty(email)) {

                    //email is empty
                    editTextEmail.setError(getString(R.string.error_field_required));
                    ready = "false";
                }
                if (TextUtils.isEmpty(password)) {

                    //password is empty
                    editTextPassword.setError(getString(R.string.error_field_required));
                    ready = "false";

                }
                if (TextUtils.isEmpty(name)) {

                    //firstName is empty
                    editTextName.setError("This field is required");
                    ready = "false";

                }
                if (TextUtils.isEmpty(type)) {
                    Toast.makeText(RegisterActivity.this, "Selct either patient or doctor", Toast.LENGTH_SHORT).show();
                    ready = "false";
                }

                if (ready.equals("true")) {
                    progressDialog.setMessage("Registering User...");
                    progressDialog.show();

                    firebaseAuth.createUserWithEmailAndPassword(email, password)
                            .addOnCompleteListener(new OnCompleteListener<AuthResult>() {
                                @Override
                                public void onComplete(@NonNull Task<AuthResult> task) {
                                    if (task.isSuccessful()){
                                        final UserInformation user = new UserInformation(
                                                name,
                                                email,
                                                type
                                        );

                                        FirebaseDatabase.getInstance().getReference("Users")
                                                .child(FirebaseAuth.getInstance().getCurrentUser().getUid())
                                                .setValue(user).addOnCompleteListener(new OnCompleteListener<Void>() {
                                            @Override
                                            public void onComplete(@NonNull Task<Void> task) {

                                                if (task.isSuccessful()){
                                                    Toast.makeText(RegisterActivity.this, "Registered Successfully", Toast.LENGTH_SHORT).show();
                                                    //finish();
                                                    progressDialog.dismiss();
                                                    if (user.getType().equals("doctor")){
                                                        startActivity(new Intent(getApplicationContext(),DoctorActivity.class));
                                                    }else {
                                                        startActivity(new Intent(getApplicationContext(),PatientActivity.class));
                                                    }

                                                }
                                            }
                                        });
                                    }
                                }
                            });
                }
            }
        });
    }
}
