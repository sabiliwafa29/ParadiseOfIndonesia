import { cn } from "@/lib/utils";

interface ButtonProps extends React.ButtonHTMLAttributes<HTMLButtonElement> {
  variant?: "default" | "secondary" | "destructive" | "outline" | "ghost" | "link";
  asChild?: boolean;
}

const Button = React.forwardRef<HTMLButtonElement, ButtonProps>({
  className: "inline-flex items-center justify-center rounded-md text-sm font-medium transition-colors focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-ring focus-visible:ring-offset-2 disabled:opacity-50 disabled:pointer-events-none [&_svg]:shrink-0 [&_svg]:pointer-events-none [&_svg]:fill-current [&_svg]:size-4",
  variant: "default",
  ...props,
}) => {
  const { className, variant, asChild, children, ...propsRest } = props;
  const MapVariants = {
    default: "bg-primary text-primary-foreground hover:bg-primary/90",
    secondary: "bg-secondary text-secondary-foreground hover:bg-secondary/80",
    destructive: "bg-destructive text-destructive-foreground hover:bg-destructive/90",
    outline: "border border-input bg-background hover:bg-accent hover:bg-accent/90",
    ghost: "hover:bg-accent hover:bg-accent/20",
    link: "underline-offset-4 hover:underline text-primary/60",
  };

  return asChild ? (
    <button {...propsRest} className={cn("")} />
  ) : (
    <button
      className={cn(
        "inline-flex items-center justify-center rounded-md text-sm font-medium transition-colors focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-ring focus-visible:ring-offset-2 disabled:opacity-50 disabled:pointer-events-none [&_svg]:shrink-0 [&_svg]:pointer-events-none [&_svg]:fill-current [&_svg]:size-4",
        MapVariants[variant],
        className,
      )}
      {...propsRest}
    />
  );
});

Button.displayName = "Button";

export { Button };
