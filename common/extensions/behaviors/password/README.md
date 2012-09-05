<h1>Yii Password Strategies</h1>

Password strategies are specifications for how passwords should be encoded and verified
and how complicated user supplied passwords should be. Out of the box it contains strategies
for bcrypt and multiple rounds of hash functions e.g. sha1, as well as support for legacy password
hashes like unsalted md5 and unsalted sha1. The aim is to allow multiple different password strategies to co-exist
and to upgrade users from legacy hashes to new hashes when they login.

<h2>Why do I want this?</h2>

Imagine that you have a legacy application that uses simple, unsalted md5 based password
hashing, which, in 2012 is considered completely insecure. You want to upgrade your password
hashes, but you don't have access to the plain text passwords. In this scenario you can
configure two password strategies, your old legacy one that uses md5, and your new shiney one
that uses bcrypt. Then when users login to their accounts, their password will be verified using
the legacy strategy, and if it matches, they will be seamlessly upgraded to the new bcrypt password
strategy. For example:

<pre>
class User extends CActiveRecord
{
	public function behaviors()
	{
		return array(
			"APasswordBehavior" => array(
				"class" => "APasswordBehavior",
				"defaultStrategyName" => "bcrypt",
				"strategies" => array(
					"bcrypt" => array(
						"class" => "ABcryptPasswordStrategy",
						"workFactor" => 14
					),
					"legacy" => array(
						"class" => "ALegacyMd5PasswordStrategy",
					)
				),
			)
		);
	}

	....
}

$user = User::model()->findByPK(1); // a user using the legacy password strategy
echo $user->password; // unsalted md5, horrible
$user->verifyPassword("password"); // verifies the password using the legacy strategy, and rehashes based on bcrypt strategy
echo $user->password; // now hashed with bcrpt
</pre>

But this is also useful for modern applications, let's say you have a new webapp and you're doing The Right Thing
and using bcrypt for your password hashing. You start off with a work factor of 12, but after a few months you decide
you'd like to increase it to 15. Normally this would be quite difficult to accomplish because of all the users who've already
signed up using the less secure hashes, but with password strategies, you can simply add another bcrpyt strategy with the
desired work factor, set it to the default, and your users will be upgraded to the new strategy next time they login.

By default, APasswordBehavior assumes that your model contains the following fields:
<ul>
	<li><strong>salt</strong> - holds the per user salt used for hashing passwords</li>
	<li><strong>password</strong> - holds the hashed password</li>
	<li><strong>password_strategy</strong> - holds the name of the current password strategy for this user
	<li><strong>requires_new_password</strong> - a boolean field that determines whether the user should change their password or not
</ul>

You can configure the field names on the behavior.